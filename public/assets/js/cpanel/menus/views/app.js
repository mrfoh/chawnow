define(['collections/menus','collections/items', 'views/menu','views/item'],
 function (MenuCollection, MenuItemCollection, MenuView, ItemView) {

	var AppView = Backbone.View.extend({

		el: "#app",

		events: {
			'click .toogle-menu-form': "toggleMenuForm",
			'click .toggle-item-form': "toggleItemForm",
			'click .new-trigger': "toggleNewForm",
			'click #save-category-btn':"saveCategory",
			'change #item-menu': "onItemMenuChange",
			'click #save-menu-btn': "addMenu",
			'click #save-item-btn': "addItem"
		},

		ui: {
			'menuForm': '#menu-form',
			'menulist': '.menu-list',
			'itemlist': '.item-list',
			'itemname': '#item-name',
			'itemprice': '#item-price',
			'itemmenu': "#item-menu",
			'itemcategory': '#item-category',
			'itemstatus': "#item-status"
		},

		setUpUi: function() {
			var self = this;

			_.each(_.keys(self.ui), function(key) {
			    var selector = self.ui[key];
			    this.ui[key] = $(selector);
			}, this);
		},

		bindPlugins: function() {
			var self = this;

			$("#menu-item-modal").on('show', function() {
				var menus = new Array();
				self.menus.each(function(menu) {
					var obj = { id: menu.id, text: menu.get('name') };
					menus.push(obj);
				});
				
				self.ui.itemmenu.select2({
					placeholder: "Select a menu",
					data: function() { return {results: menus} }
				});

				self.ui.itemcategory.select2({
					placeholder: "Select a category",
					data: function() { return {results: {}} }
				});
			});

			$("#menu-item-modal").on('hide', function() {
				$(this).attr('data-mode','create');

				self.ui.itemname.val('');
				self.ui.itemprice.val('');

				self.ui.itemmenu.html('');
				self.ui.itemmenu.select2('data', null, false);

				self.ui.itemcategory.html('');
				self.ui.itemcategory.select2('destroy');
			});
		},

		initialize: function() {

			this.setUpUi();
			//instantiate the MenuCollection
			this.menus = new MenuCollection;
			this.menus.comparator = 'name';
			//instantiate the MenuItemCollection
			this.menuitems = new MenuItemCollection;

			//bind to collection events
			this.menus.on('add', this.renderMenu, this);
			this.menus.on('remove', this.renderMenuList, this);
			this.menus.on('reset', this.renderMenuList, this);

			this.menuitems.on('add', this.renderItem, this);
			this.menuitems.on('remove', this.renderItems, this);
			this.menuitems.on('reset', this.renderItems, this);

			//reset collections
			this.menus.reset(menus);
			this.menuitems.reset(menu_items);

			this.bindPlugins();
		},
		/** Collection methods **/
		renderMenuList: function() {
			if(this.menus.length < 1) {
				//show empty message
				$('.menus-empty').show()
			}
			else {
				$('.menus-empty').hide();
				//render menus
				this.ui.menulist.html('');
				this.menus.each(this.renderMenu, this);
			}
		},

		renderMenu: function (menu) {
			$('.menus-empty').hide();

			var template = _.template( $('#menu-tmpl').html() ),
				view = new MenuView({ model: menu, template: template, parent: this});

				this.ui.menulist.prepend( view.render().el );
		},

		renderItem: function (item) {
			$('.menu-items-empty').hide()

			var template = _.template( $('#menu-item-tmpl').html() ),
				view = new ItemView({ model: item, template: template, parent: this});

				this.ui.itemlist.prepend(view.render().el);
		},

		renderItems: function() {
			if(this.menuitems.length < 1) {
				$('.menu-items-empty').show();
			}
			else {
				$('.menu-items-empty').hide();
				this.ui.itemlist.html('');
				this.menuitems.each(this.renderItem, this);	
			}
		},

		/** Utility Methods **/
		populateCategories: function (categories) {
			
			var items = new Array();
			_.each(categories, function(category) {
				var obj = { id: category.id, text: category.name};
				items.push(obj);
			});

			this.ui.itemcategory.select2({data: items});
		},

		/** UI Event Methods **/ 
		toggleMenuForm: function() {
			this.ui.menuForm.slideToggle();
		},

		toggleItemForm: function() {
			$('#menu-item-modal').modal('toggle')
		},

		toggleNewForm: function (event) {

			var el = $(event.currentTarget);
			var form = el.next();

			form.slideToggle();

			event.preventDefault();
		},

		saveCategory: function (event) {

			var el = $(event.currentTarget),
				self = this;

				el.prop('disbabled', true);
				el.html('Saving...');

			if(!this.ui.itemmenu.val())
				alert("Please select a menu");

			var data = { name: $('#new-category-name').val(), menu: this.ui.itemmenu.val()};
			var url = Cpanel.Constants.url+"/menus/category";

			$.ajax({
				url: url,
				type:'POST',
				data: data,
				dataType: 'json',
				success: function (response, status, xhr) {
					if(response.status == "success") {
						//category name field
						$('#new-category-name').val('');
						//enable button
						el.prop('disbabled', false);
						//revert to original button text
						el.html('Save Category');
						//hide form
						$('.new-form').slideUp();
						//find menu
						var id = response.model.menu_id;
						var menu = self.menus.get(id);
						//add category to the menu
						var categories = menu.get('categories');
						categories.push(response.model);

						self.populateCategories(categories);
					}
				}
			})
		},

		onItemMenuChange: function (event) {

			var el = $(event.currentTarget);
				id = el.val();

			var menu = this.menus.get(id),
				categories = menu.get('categories');

			this.populateCategories(categories);
		},

		addMenu: function (event) {

			var el = $(event.currentTarget), self = this;
			//focus on name field
			$('#menu-name').focus();
			//disbable button
			el.prop('disbabled', true);
			el.html('Saving...');
			//new model
			var model = { name: $("#menu-name").val(), active: $("#menu-status").val(), restaurant_id: rid };
			//create new model in collection
			this.menus.create(model, {
				wait: true,
				success: function (model, response, options) {
					self.addMenuSuccess(model, response, options, self);
				}
			});
		},

		addMenuSuccess: function (model, response, options, view) {
			if(response) {

				$("#save-menu-btn").prop('disbabled', false);
				$("#save-menu-btn").html('Save');

				view.ui.menuForm.find('#menu-name').val('');
				view.ui.menuForm.delay(1000).slideUp();
			}
		},

		addItem: function (event) {

			var el = $(event.currentTarget),
				self = this, modal = $('#menu-item-modal'),
				mode = modal.attr('data-mode');
				//disbable button
				el.prop('disbabled', true);
				//show process activity indicator
				el.html('Saving...');

			//new item model
			var model = {
				"restaurant_id": rid,
				"name": this.ui.itemname.val(),
				"price": this.ui.itemprice.val(),
				"menu_id": this.ui.itemmenu.val(),
				"menu_category_id": this.ui.itemcategory.val(),
				"active": this.ui.itemstatus.val()
			};

			if(mode == "create") {
				this.menuitems.create(model, {
					wait: true,
					success: function (model, response, options) {
						if(response) {
							el.prop('disbabled', false);
							el.html('Save');

							$('#menu-item-modal').modal('hide')
						}
					}
				});
			}
			else if(mode == "edit") {
				var id = modal.attr('data-model-id');
				var item = this.menuitems.get(id);
				var attrs = { 
					"name": this.ui.itemname.val(),
					"price": this.ui.itemprice.val(),
					"menu_id": this.ui.itemmenu.val(),
					"menu_category_id": this.ui.itemcategory.val(),
					"active": this.ui.itemstatus.val()
				}
				console.log(item);

				item.save(attrs, {
					wait: true,
					success: function (model, response, options) {
						if(response) {
							el.prop('disbabled', false);
							el.html('Save');

							$('#menu-item-modal').modal('hide')
						}
					}
				});
			}
		}
	});

	return AppView;
});
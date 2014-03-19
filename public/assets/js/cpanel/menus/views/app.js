define(['collections/menus', 'views/menu'], function (MenuCollection,  MenuView) {

	var AppView = Backbone.View.extend({

		el: "#app",

		events: {
			'click .toogle-menu-form': "toggleMenuForm",
			'click #save-menu-btn': "addMenu",
			'click .item .activate-item': 'activateItem',
			'click .item .deactivate-item': 'deactivateItem'
		},

		ui: {
			'menuForm': '#menu-form',
			'menulist': '.menu-list'
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

		},

		initialize: function() {

			this.setUpUi();
			//instantiate the MenuCollection
			this.menus = new MenuCollection;
			this.menus.comparator = 'name';
		
			//bind to collection events
			this.menus.on('add', this.renderMenu, this);
			this.menus.on('remove', this.renderMenuList, this);
			this.menus.on('reset', this.renderMenuList, this);

			//reset collections
			this.menus.reset(menus);

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

		/** UI Event Methods **/ 
		toggleMenuForm: function() {
			this.ui.menuForm.slideToggle();
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

		activateItem: function (event) {
			var el = $(event.currentTarget),
				id = el.attr('data-id'),
				url = Cpanel.Constants.url+"/menus/item/activate/"+id;

				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'json',
					success: function (response, status, xhr) {
						if(response.status == "success") {
							el.attr('class','deactivate-item');
							el.attr('title','Click to deactivate item');
							el.find('div.status-icon').removeClass('red').addClass('green');
						}
					}
				});

			event.preventDefault();
		},

		deactivateItem: function (event) {
			var el = $(event.currentTarget),
				id = el.attr('data-id'),
				url = Cpanel.Constants.url+"/menus/item/deactivate/"+id;

				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'json',
					success: function (response, status, xhr) {
						if(response.status == "success") {
							el.attr('class','activate-item');
							el.attr('title','Click to activate item');
							el.find('div.status-icon').removeClass('green').addClass('red');
						}
					}
				});

			event.preventDefault();
		}
	});

	return AppView;
});
Cpanel.Views.ItemFormView = Backbone.View.extend({
	el: "#menu-item-form-app",

	ui: {
		'menu': "#menu_id",
		'menu_category': "#menu_category_id",
		'item_group': "#item_group_id",
		'optionform': '.option-form',
		'optionvalueform': '.option-value-form'
	},

	events: {
		'click .form-toggle': 'toggleForm',
		'change #menu_id': 'onMenuChange',
		'change #menu_category_id': 'onCategoryChange',
		'click #save-category': 'saveCategory',
		'click #save-group': 'saveGroup',
		'click .toggle-option-form': 'toggleOptionForm',
		'click .toggle-value-form': 'toggleValueForm',
		'click .add-option-btn': 'addOption',
		'click .add-option-value': 'addOptionValue',
		'click .remove-option': 'removeOption',
		'click .remove-value': 'removeValue'
	},

	setUpUi: function() {
		var self = this;

		_.each(_.keys(self.ui), function(key) {
		    var selector = self.ui[key];
		    this.ui[key] = $(selector);
		}, this);

	},

	populateMenus: function () {
		var menus = new Array();

		this.menus.each(function(menu) {
			var obj = { id: menu.id, text: menu.get('name') };
			menus.push(obj);
		});

		return menus;
	},

	populateCategories: function (categories) {
		var items = new Array();

		_.each(categories, function(category) {
			var obj = { id: category.id, text: category.name};
			items.push(obj);
		});

		this.ui.menu_category.select2({placeholder: "Select a menu category", data: items});
	},

	populateGroups: function (groups) {
		var items = new Array();

		_.each(groups, function(group) {
			var obj = { id: group.id, text: group.name};
			items.push(obj);
		});

		this.ui.item_group.select2({placeholder: "Select a menu category group", data: items});
	},

	setUpForm: function() {
		var self = this;

		//populate menus dropdown
		this.ui.menu.select2({
			placeholder: "Select a menu",
			data: function() { return {results: self.populateMenus() } }
		});
		//create menu category dropdown
		this.ui.menu_category.select2({
			placeholder: "Select a menu category",
			data: function() { return {results: {}} }
		});
		//create menu category group dropdown
		this.ui.item_group.select2({
			placeholder: "Select a menu category group",
			data: function() { return {results: {}} }
		});
	},

	setFormValues: function() {
		var self = this;

		//set category
		if(this.ui.menu.val()) {
			var menu = this.menus.get(this.ui.menu.val()),
				categories = menu.get('categories');

			this.populateCategories(categories);
			this.ui.menu_category.select2('val', this.ui.menu_category.val());
		}

		//set group
		if(this.ui.menu_category.val()) {

			var menu = this.menus.get(this.ui.menu.val()),
				categories = menu.get('categories'),
				thiscategory;

			_.each(categories, function(category) {
				if(category.id == self.ui.menu_category.val()) {
					thiscategory = category;
				}
			});

			this.populateGroups(thiscategory.groups);
			this.ui.item_group.select2('val', this.ui.item_group.val());
		}
	},

	initialize: function() {

		this.menus = new Backbone.Collection;
		this.menus.reset(menus);

		this.setUpUi();
		this.setUpForm();
		this.setFormValues();
	},

	/** Event Handlers **/
	toggleForm: function (event) {

		$(event.currentTarget).next().slideToggle();

		event.preventDefault();
	},

	onMenuChange: function (event) {

		var el = $(event.currentTarget),
			id = el.val(),
			menu = this.menus.get(id),
			categories = menu.get('categories');

		this.populateCategories(categories);
	},

	onCategoryChange: function (event) {

		var el = $(event.currentTarget);
				id = el.val(),
				menuid = this.ui.menu.val();

		var menu = this.menus.get(menuid);
		var categories = menu.get('categories');
		var thiscategory;

		_.each(categories, function(category) {
			if(category.id == id) {
				thiscategory = category;
			}
		});

		this.populateGroups(thiscategory.groups);
	},

	saveCategory: function (event) {

			var el = $(event.currentTarget),
				self = this;

				el.prop('disbabled', true);
				el.html('Saving...');

			if(!this.ui.menu.val())
				alert("Please select a menu");

			var data = { name: $('#category-name').val(), menu: this.ui.menu.val()};
			var url = Cpanel.Constants.url+"/menus/category";

			$.ajax({
				url: url,
				type:'POST',
				data: data,
				dataType: 'json',
				success: function (response, status, xhr) {
					if(response.status == "success") {
						//category name field
						$('#category-name').val('');
						//enable button
						el.prop('disbabled', false);
						//revert to original button text
						el.html('Save');
						//hide form
						$('#category-name').parent('div').slideUp();
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

		saveGroup: function (event) {
			var el = $(event.currentTarget),
				self = this;

				el.prop('disbabled', true);
				el.html('Saving...');

			if(!this.ui.menu_category.val())
				alert("Please select a category");

			var data = { name: $('#group-name').val(), menu: this.ui.menu.val(), category: this.ui.menu_category.val() };
			var url = Cpanel.Constants.url+"/menus/group";

			$.ajax({
				url: url,
				type:'POST',
				data: data,
				dataType: 'json',
				success: function (response, status, xhr) {
					if(response.status == "success") {
						//category name field
						$('#group-name').val('');
						//enable button
						el.prop('disbabled', false);
						//revert to original button text
						el.html('Save');
						//hide form
						$('#group-name').parent('div').slideUp();
						//find category
						var model = response.model;
						var id = model.menu_category_id;
						var menu = self.menus.get(data.menu);
						var categories = menu.get('categories');
						var thiscategory;
						
						_.each(categories, function(category) {
							if(category.id == id) {
								category.groups.push(model);
								thiscategory = category;
							}
						});

						self.populateGroups(thiscategory.groups);
					}
				}
			})
	},

	toggleOptionForm: function( event ) {

		this.ui.optionform.slideToggle();
	},

	toggleValueForm: function (event) {
		var el = $(event.currentTarget),
			form = el.next();

		form.slideToggle();
		event.preventDefault();
	},

	addOption: function (event) {

		var name = $('#option-name').val();
		var template = _.template($('#option-tmpl').html());
		var id = Math.floor(Math.random() * (999 - 1 + 1)) + 1;

		var option = {
			id: id,
			name: name,
			required: true,
			values: [],
			serialized: undefined
		}

		option.serialized = JSON.stringify({
			name: option.name,
			required: option.required,
			values: new Array()
		});

		$('.option-list').prepend(template(option));
		$('#option-name').val('');

		this.ui.optionform.slideToggle();
	},

	addOptionValue: function (event) {

		var el = $(event.currentTarget),
			list = el.parent('div').siblings('ul'),
		    form = el.parent('div'),
			input = form.next(),
			option = JSON.parse(input.val()),
			value = form.find('#option-value').val(),
			price = form.find('#option-value-price').val();

		var template = _.template($('#option-value-tmpl').html());	

		var data = {
			value: value,
			price: price
		};

		form.find('#option-value').val('');
		form.find('#option-value-price').val('');

		option.values.push(data);
		
		input.val(JSON.stringify(option));

		list.prepend(template(data));
		form.slideToggle();
	},

	removeOption: function (event) {
		var el = $(event.currentTarget);
			option = el.parent('div').parent('li');

		option.fadeOut().remove();

		event.preventDefault();
	},

	removeValue: function (event) {
		var el = $(event.currentTarget);
			value = el.parent('div').parent('li'),
			input = value.parent('ul').parent('li').find('.option-data'),
			optiondata = JSON.parse(input.val());

		
		//add remaining values
		var list = el.parent('div').parent('li').parent('ul');
		//remove value
		value.fadeOut().remove();
		//clear values
		optiondata.values.length = 0;
		//add remaining
		var remaining = list.find('li').each(function() {

			var data = { value: $(this).attr('data-value'), price: $(this).attr('data-price')};
			optiondata.values.push(data)

		});

		input.val(JSON.stringify(optiondata));

		event.preventDefault();
	}
});
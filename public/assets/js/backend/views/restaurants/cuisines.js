Backend.Views.CuisinesView = Backbone.View.extend({
	el: "#app",

	ui: {
		'list': ".cuisine-list",
		'addBtn': "#add-btn",
		'name': "#name",
		'slug': '#slug'
	},

	events: {
		'click .remove-cuisine': 'removeCuisine',
		'click #add-btn': 'addCuisine',
		'keydown #name': 'onNameKeydown'
	},

	setUpUi: function() {
		var self = this;

		_.each(_.keys(self.ui), function(key) {
		    var selector = self.ui[key];
		    this.ui[key] = $(selector);
		}, this);

	},

	initialize: function() {

		this.setUpUi();

		this.collection = new Backbone.Collection;
		this.collection.on('reset', this.addAll, this);
		this.collection.on('remove', this.addAll, this);
		this.collection.on('add', this.addOne, this);

		this.collection.reset(cuisines);
	},

	addAll: function() {
		this.ui.list.html('');
		this.collection.each(this.addOne, this);
	},

	addOne: function (cuisine) {
		var template = $('#cuisine-tmpl').html(),
			compliedTemplate = _.template(template);

		this.ui.list.prepend( compliedTemplate(cuisine.toJSON()) );
	},

	removeCuisine: function (event) {
		var el = $(event.currentTarget),
			id = el.attr('data-id');
			url = Backend.Constants.url+"/cuisines/remove/"+id,
			self = this;

		$.ajax({
			url: url,
			type: "GET",
			dataType: "json",
			success: function (response, status, xhr) {

				if(response.status == "success") {
					var model = self.collection.get(id);
					self.collection.remove(model);
					alert(response.message);
				}
			}
		})
		event.preventDefault();
	},

	addCuisine: function (event) {
		var el = $(event.currentTarget),
			url = Backend.Constants.url+"/cuisines/add";
			data = { name: this.ui.name.val(), slug: this.ui.slug.val() },
			self = this;

		el.prop('disabled', true);
		el.html('Adding...');

		$.ajax({
			url: url,
			type: "POST",
			data: data,
			dataType: 'json',
			success: function (response, status, xhr) {
				self.addSuccess(response, status, xhr, self);
			}
		});
	},

	addSuccess: function (response, status, xhr, view) {

		if(response.status == "success")
		{
			view.ui.addBtn.prop('disabled', false);
			view.ui.addBtn.html('Add');

			view.ui.name.val('');
			view.ui.slug.val('')

			view.collection.add(response.model);
		}
	},

	onNameKeydown: function (event) {

		var el = $(event.currentTarget),
			fieldval = el.val(),
			slugval = fieldval.toLowerCase();

		this.ui.slug.val(slugval);
	}
})
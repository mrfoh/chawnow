Chawnow.Views.AddressView = Backbone.View.extend({
	tagName: 'li',

	initialize: function (options) {
		this.template = options.template;
		this.parent = options.parent;
	},

	render: function() {
		this.$el.html( this.template( this.model.toJSON() ) );
		return this;
	},

	events: {
		'click .delete-address': 'onDeleteAddressClick',
		'click .edit-address': 'onEditAddressClick'
	},

	onDeleteAddressClick: function (event) {
		var el = $(event.currentTarget),
			id = el.attr('data-id'),
			self = this;

		var url = Chawnow.Constants.url+"/account/addresses/"+id+"/delete";

		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json',
			success: function (response, status, xhr) {
				self.addressDeleteSuccess(response, status, xhr, self);
			}
		});
		event.preventDefault();
	},

	onEditAddressClick: function (event) {

		event.preventDefault();
	},	

	addressDeleteSuccess: function (response, status, xhr, view) {
		if(response.status == "success") {
			view.model.collection.remove(view.model);
		}
	}
});

Chawnow.Views.AddressesPage = Backbone.View.extend({
	el: ".account-page",

	setUpUi: function() {
		var self = this;

		_.each(_.keys(self.ui), function(key) {
			var selector = self.ui[key];
			this.ui[key] = $(selector);
		}, this);
	},

	initialize: function()
	{
		this.setUpUi();

		this.collection = new Backbone.Collection;

		this.collection.on('reset', this.renderAll, this);
		this.collection.on('add', this.renderOne, this);
		this.collection.on('remove', this.renderAll, this);

		this.collection.reset(Chawnow.data.addresses);
	},

	events: {
		'click .empty-toggle-form': 'toggleFormAndEmptyBox',
		'click .toggle-form': 'toggleForm',
		'click #save-btn': 'onSaveBtnClick'
	},

	ui: {
		'empty': '.empty',
		'list': '.address-list',
		'form': '.address-form',
		'toggle': '.toggle-form',
		'name': '#name',
		'text': '#text',
		'saveBtn': "#save-btn"
	},

	renderOne: function (address) {
		var template = _.template($('#address-tmpl').html());
		var view = new Chawnow.Views.AddressView({model: address, template: template, parent: this});
		if(!this.ui.list.is(':visible'))
			this.ui.list.show();
		if(!this.ui.toggle.is(':visible'))
			this.ui.toggle.show();
		//render address
		this.ui.list.prepend( view.render().el );
	},

	renderAll: function() {
		if(this.collection.length < 1) {
			this.ui.list.hide();
			this.ui.toggle.hide();
			this.ui.empty.show();
		}
		else {
			this.ui.list.html('');
			this.ui.list.show();
			this.ui.toggle.show();

			this.collection.each(this.renderOne, this);
		}
	},

	toggleFormAndEmptyBox: function (event) {
		var el = $(event.currentTarget);

		if(this.ui.form.is(':visible')) {
			this.ui.empty.slideDown();
			this.ui.form.slideUp();
		}
		else {
			this.ui.empty.slideUp();
			this.ui.form.slideDown();
		}

		event.preventDefault();
	},

	toggleForm: function(event) {

		$(event.currentTarget).hide();
		this.ui.form.slideToggle();
	},

	onSaveBtnClick: function (event) {

		var el = $(event.currentTarget);
		//disbale form controls
		this.ui.name.prop('disabled', true);
		this.ui.text.prop('disabled', true);
		el.prop('disabled', true);
		//show activity in button
		el.html('<i class="icon-spinner icon-spin"></i> Saving...');

		var data = { name: this.ui.name.val(), text: this.ui.text.val() },
			url = Chawnow.Constants.url+"/account/addresses",
			self = this;

		$.ajax({
			url: url,
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function (response, status, xhr) {
				self.addressSaveSuccess(response, status, xhr, self);
			}
		});
	},


	addressSaveSuccess: function (response, status, xhr, view) {
		if(response.status == "success") {
			//enable form controls
			view.ui.name.prop('disabled',false);
			view.ui.text.prop('disabled', false);
			view.ui.saveBtn.prop('disabled', false);
			view.ui.saveBtn.html('Save');
			//clear fields
			view.ui.name.val('');
			view.ui.text.val('');
			//add model to collection
			view.collection.add(response.model);
			//hide form
			view.ui.form.slideUp();
		}
	}
});
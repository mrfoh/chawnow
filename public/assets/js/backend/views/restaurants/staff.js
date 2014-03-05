Backend.Views.RestuarantStaffView = Backbone.View.extend({
	el: "#app",

	ui: {
		'empty': '.empty',
		'list': '.staff-list',
		'name': "#name"
	},

	events: {
		"click #add-btn": "onAddBtnClick",
		"click .remove-staff": "onRemoveStaffClick"
	},

	setUpUi: function() {
		var self = this;

		_.each(_.keys(self.ui), function(key) {
		    var selector = self.ui[key];
		    this.ui[key] = $(selector);
		}, this);

	},

	bindPlugins: function() {
		this.ui.name.typeahead({ source: users });
	},

	initialize: function() {

		this.setUpUi();
		this.bindPlugins();

		this.staff = new Backbone.Collection;

		this.staff.on('reset', this.addAll, this);
		this.staff.on('remove', this.addAll, this);
		this.staff.on('add', this.addOne, this);

		this.staff.reset(staff);
	},

	addOne: function (staff) {
		var template = $('#staff-tmpl').html(),
			compliedTemplate = _.template(template);

		this.ui.list.prepend( compliedTemplate(staff.toJSON()) );
	},

	addAll: function() {
		console.log(this.staff);
		if(this.staff.length > 0) {
			this.ui.list.html('');
			this.staff.each(this.addOne, this);
		}
		else
		{
			this.ui.empty.show();
		}
	},

	onAddBtnClick: function (event) {

		var url = Backend.Constants.url+"/restaurants/"+rid+"/staff/add",
			data = { name: this.ui.name.val() },
			self = this,
			btn = $('#add-btn');

		btn.prop('disabled', true);
		btn.html('Adding');

		$.ajax({
			url: url,
			data: data,
			type: "POST",
			dataType: "json",
			success: function (response, status, xhr) {
				self.addSuccess(response, status, xhr, self);
			}
		});
	},

	onRemoveStaffClick: function (event) {

		var el = $(event.currentTarget),
			id = el.attr('data-id'),
			url = Backend.Constants.url+"/restaurants/"+rid+"/staff/remove/"+id,
			self = this;

		$.ajax({
			url: url,
			type: "GET",
			dataType: "json",
			success: function (response, status, xhr) {
				if(response.status == "success") {
					var model = self.staff.get(id);
					self.staff.remove(model);
					alert(response.message);
				}
			}
		})

		event.preventDefault();
	},

	addSuccess: function (response, status, xhr, view) {
		if(response.status == "success")
		{
			var btn = $('#add-btn');
			var name = $('#name');

			btn.html('Add');
			btn.prop('disabled',false);
			name.val('');

			view.staff.add(response.model);
		}
		else if(response.status == "error")
		{
			var btn = $('#add-btn');
			var name = $('#name');

			btn.html('Add');
			btn.prop('disabled',false);
			name.val('');

			alert(response.message);
		}
	}
})
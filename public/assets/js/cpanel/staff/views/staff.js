define(function() {
	'use strict';

	var StaffView = Backbone.View.extend({

		tagName: 'li',

		events: {
			'click a.remove-staff': 'onRemoveStaffClick',
		},

		initialize: function(options) {
			this.template = options.template;
			this.parent = options.parent;
		},

		render: function() {
			this.$el.html( this.template( this.model.toJSON() ) );
			return this;
		},

		onRemoveStaffClick: function (event) {
			var el = $(event.currentTarget),
				userid = el.attr('data-user-id'),
				id = el.attr('data-id'),
				actionUrl = Cpanel.Constants.url+"/staff/"+userid+"/remove",
				self = this;

			$.ajax({
				url: actionUrl,
				type: 'GET',
				async: false,
				dataType: 'json',
				success: function (response, status, xhr) {
					var collection = self.model.collection;
					console.log(self.model);
					collection.remove(self.model);

					if(response.status == "success")
					{
						$.gritter.add({
					        title: 'Success!!!',
					        text: "Staff successfully removed",
					        sticky: false,
					        time: '5000'
					    });
					}
				},
				error: function (i, j, k) {
					$.gritter.add({
				        title: 'Error!!!',
				        text: "Oops!, an error occured, please try again later",
				        sticky: false,
				        time: '5000'
				    });
				}
			})
			event.preventDefault();
		}
	});

	return StaffView;
});
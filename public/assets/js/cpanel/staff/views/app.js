define(['views/staff'], function (StaffView) {

	var AppView = Backbone.View.extend({
		el: "#staff-app",

		ui: {
			'empty': '.empty',
			'stafflist': '.staff-list',
			'staffForm': '#staff-form',
			'first_name': "#first_name",
			'last_name': "#last_name",
			'submitBtn': '.btn-submit',
			'email': "#email"
		},

		events: {
			//'click .btn-submit': 'onSubmitBtnClick'
		},

		formValidationRules: {
			first_name: {
				required: true
			},
			last_name: {
				required: true
			},
			email: {
				required: true,
				email: true
			}
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
			this.bindPlugins();

			this.collection = new Backbone.Collection;

			this.collection.on('reset', this.renderAllStaff, this);
			this.collection.on('remove', this.renderAllStaff, this);
			this.collection.on('add', this.renderStaff, this);

			this.collection.reset(staff);
		},


		bindPlugins: function() {
			var self = this;
			//form validation
			this.ui.staffForm.validate({
				rules: self.formValidationRules,
				onfocusout: function (element) {
				        $(element).valid();
			    },
	            errorPlacement: function (label, element) { // render error placement for each input type   
					$('<span class="error"></span>').insertAfter(element).append(label)
	                 var parent = $(element).parent('.controls');
	                 parent.removeClass('success-control').addClass('error-control');  
	            },

	            success: function (label, element) {
					var parent = $(element).parent('.controls');
					parent.removeClass('error-control').addClass('success-control'); 
	            },

	            submitHandler: function (form) {
	               self.submitForm();
	            }
			});
		},

		renderAllStaff: function() {
			console.log(this.collection);
			if(this.collection.length > 0 ) {
				this.ui.stafflist.html('');
				this.ui.empty.hide();

				this.collection.each(this.renderStaff, this);
				$('a[rel="tooltip"').tooltip();
			}
			else {
				this.ui.empty.show();
			}
		},

		renderStaff: function (staff) {
			console.log("Rendering staff model:")
			console.log(staff);

			var template = _.template( $('#staff-tmpl').html() ),
				view = new StaffView({ model: staff, template: template, parent: this});

			this.ui.stafflist.prepend( view.render().el );
		},

		submitForm: function()
		{
			var self = this,
				actionUrl = this.ui.staffForm.prop('action');
				data = this.ui.staffForm.serialize();

			//disable btn
			this.ui.submitBtn.prop('disabled', true);
			this.ui.submitBtn.html('Adding....');

			//ajax request
			$.ajax({
				url : actionUrl,
				type: 'POST',
				data: data,
				dataType: 'json',
				success: function (response, status, xhr) {
					self.addStaffSuccess(response, status, xhr, self);
				},
				error: function (i, j, k) {
					$.gritter.add({
				        title: 'Error!!!',
				        text: "Oops!, an error occured, please try again later",
				        sticky: false,
				        time: '5000'
				    });
				}
			});
		},

		addStaffSuccess: function (response, status, xhr, view) {
			view.ui.submitBtn.prop('disabled', false);
			view.ui.submitBtn.html('Add');

			view.ui.first_name.val('');
			view.ui.last_name.val('');
			view.ui.email.val('');

			if(response.status == "success") {

				$.gritter.add({
			        title: 'Success!!!',
			        text: 'New staff successfully added',
			        sticky: false,
			        time: '5000'
			    });

			    this.collection.add(response.model);

			}
			else if(response.status == "error") {
				view.ui.submitBtn.prop('disabled', false);
				view.ui.submitBtn.html('Add');

				$.gritter.add({
			        title: 'Error!!!',
			        text: response.message,
			        sticky: false,
			        time: '5000'
			    });
			}
		}
	});

	return AppView;
});
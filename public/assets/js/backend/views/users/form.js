//User Form View
Backend.Views.UserFormView = Backbone.View.extend({
	el: "#app",

	validationRules: {
		firstname: {
	        required: true
	    },
	    lastname: {
	        required: true
	    },
	    password: {
	        required: true,
	        minlength: 6,
	    },
	    confpassword: {
	        required: true,
	        minlength: 6,
	        equalTo: "#password"
	    },
	    email: {
	        required: true,
	        email: true
	    }
	},

	validationMessages: {
		firstname: "Please enter your first name",
		lastname: "Please enter your last name",
		email: {
			required: "Please enter an e-mail address",
			email: "Please enter a valid e-mail address"
		},
		password: {
			required: "Please enter a password",
			minlength: "Your password must have at least 6 characters"
		},
		confpassword: {
			required: "Please confirm your password",
			minlength: "Your password must have at least 6 characters",
			equalTo: "Your passwords do not match"
		}
	},

	ui: {
		"form": "#user-form"
	},

	setUpUi: function() {
		var self = this;

		_.each(_.keys(self.ui), function(key) {
		    var selector = self.ui[key];
		    this.ui[key] = $(selector);
		}, this);

	},

	bindPlugins: function()
	{
		var self = this;
		this.ui.form.validate({
	        errorElement: 'span', 
	        errorClass: 'error', 
	        rules: self.validationRules,
	        messages: self.validationMessages,
			onfocusout: function (element) {
			        $(element).valid();
			},
	        invalidHandler: function (event, validator) {
				//display error alert on form submit    
	        },
	        errorPlacement: function (label, element) { // render error placement for each input type   
				$('<span class="error"></span>').insertAfter(element).append(label)
	        },
	        success: function (label, element) {
	           var labels = $(element).siblings('span');
	           labels.each(function() {
	           		$(this).remove();
	           })
	        },
	        submitHandler: function (form) {
	            form.submit();
	        }
	    });
	},

	initialize: function()
	{
		this.setUpUi();
		this.bindPlugins();
	}
});
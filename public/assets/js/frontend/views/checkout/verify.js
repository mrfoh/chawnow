Chawnow.Views.VerificationPage = Backbone.View.extend({
	el : ".verification-page",

	setUpUi: function() {
		var self = this;

		_.each(_.keys(self.ui), function(key) {
			var selector = self.ui[key];
			this.ui[key] = $(selector);
		}, this);
	},

	initialize: function() {
		this.setUpUi();
		this.actionurl = this.ui.form.prop('action');
	},

	ui: {
		'form': "#verify-form",
		'code': "#code",
		'btn': '.verify-btn'
	},

	events: {
		'click .verify-btn': 'onVerifyBtn',
		'blur #code': 'onBlurCode'
	},

	onVerifyBtn: function (event) {

		var el = $(event.currentTarget), self = this;
			el.prop('disabled', true);
			el.html('Verifying...');

		var data = { code: this.ui.code.val() };

		$.ajax({
			url: self.actionurl,
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function (response, status, xhr) {
				el.prop('disabled', false);
				self.verifyRequestSuccess(response, status, xhr, self);
			}
		})

		event.preventDefault();
	},

	verifyRequestSuccess: function (response, status, xhr, view) {
		if(response.status == "success")
		{
			view.ui.btn.html('Verified');
			window.location = Chawnow.Constants.url+"/order/"+Chawnow.data.orderid+"/complete";
		}
		else if(response.status == "error")
		{
			view.ui.btn.html('Verify Order');
			view.ui.btn.prop('disabled', false);
			alert(response.message);
		}
	},

	onBlurCode: function (event) {

		var el = $(event.currentTarget);

		if(!el.val())
			alert("Please enter your verification code");
	}
});

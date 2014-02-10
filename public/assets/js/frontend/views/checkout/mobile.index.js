Chawnow.Views.CheckoutPage = Backbone.View.extend({
	el: "#checkout-page",

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
	},

	events: {
		'change input[name="delivery_type"]': 'onDeliveryTypeChange'
	},

	ui: {
		'cart': '.user-cart',
	},

	onDeliveryTypeChange: function (event) {
		var el = $(event.currentTarget);

		if(el.val() == "pickup")
		{
			//remove delivery fee
			var delivery = this.ui.cart.find('.delivery-fee');
			var carttotal = this.ui.cart.find('.cart-total');
			var total = this.ui.cart.find('.total');
			var grandtotal = $('.grand-total');

			delivery.html('<b class="naira">N</b>0.00');
			var newtotal = Number(carttotal.attr('data-value')).toFixed(2);
			total.html('<b class="naira">N</b>'+newtotal);

			grandtotal.html('<b class="naira">N</b>'+newtotal);
		}
		else if(el.val() == "delivery")
		{
			//add delivery fee
			var delivery = this.ui.cart.find('.delivery-fee');
			var carttotal = this.ui.cart.find('.cart-total');
			var total = this.ui.cart.find('.total');
			var grandtotal = $('.grand-total');

			delivery.html('<b class="naira">N</b>'+ Number(delivery.attr('data-value')).toFixed(2));
			var newtotal = Number(carttotal.attr('data-value')) + Number(delivery.attr('data-value'))
			newtotal = newtotal.toFixed(2)
			total.html('<b class="naira">N</b>'+newtotal);

			grandtotal.html('<b class="naira">N</b>'+newtotal);

		}
	}
});

$(document).ready(function() {
	var view  = new Chawnow.Views.CheckoutPage();
});
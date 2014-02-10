Chawnow.Views.CheckoutPage = Backbone.View.extend({
	el: ".checkout-page",

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

		if(Chawnow.data.addressess.length > 0)
			this.renderAddressBox();
	},

	events: {
		'change input[name="delivery_type"]': 'onDeliveryTypeChange',
		'click .user-address a': 'selectAddress'
	},

	ui: {
		'cart': '.user-cart',
		'addresssbox': '.address-box'
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
	},

	renderAddressBox: function () {

		var template = _.template($('#address-box-tmpl').html());
		this.ui.addresssbox.append(template);

		var addressess = Chawnow.data.addressess;
		var collection = new Backbone.Collection;

		collection.reset(addressess);
		collection.each(this.renderAddress, this);
	},

	renderAddress: function (address) {

		var container = $('ul.addressess');
		var template = _.template($('#address-tmpl').html());

		container.prepend( template( address.toJSON() ) );
	},

	selectAddress: function (event) {
		var el = $(event.currentTarget);
		var address = el.attr('data-text');
		var street = $('#street');
		var container = $('ul.addressess');

		container.find('li.active').each(function() {
			$(this).removeClass('active');
		});

		el.parent('li').addClass('active');
		street.val(address);

		event.preventDefault();
	}
});

$(document).ready(function() {
	var view  = new Chawnow.Views.CheckoutPage();
});
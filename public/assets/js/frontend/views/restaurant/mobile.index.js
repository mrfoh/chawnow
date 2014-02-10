Chawnow.Views.RestaurantPage = Backbone.View.extend({
	el: "#restaurant-page",

	setUpUi: function() {
		var self = this;

		_.each(_.keys(self.ui), function(key) {
			var selector = self.ui[key];
			this.ui[key] = $(selector);
		}, this);
	},

	initialize: function() {
		//set up ui
		this.setUpUi();
	},

	ui: {
		'menulist': "#menu-list",
		'cart': ".user-cart",
		'cartcontent': ".cart-contents",
		'checkoutbtn': '.checkout-btn'
	},

	events: {
		'click .item':'addToCart',
		'click .reduce-qty': 'onReduceQtyClick',
		'click .increase-qty': 'onIncreaseQtyClick',
		'click .checkout-btn': 'onCheckoutBtnClick'
	},

	addToCart: function (event) {

		var el = $(event.currentTarget);
			itemid = el.attr('data-id'),
			itemprice = el.attr('data-price'),
			itemname = el.attr('data-item-name'),
			url = Chawnow.Constants.url+"/cart/add",
			data = { id : itemid, name: itemname, price: itemprice , restaurant: Chawnow.data.restaurant.uid },
			self = this;

		$.mobile.loading('show', { text: "Adding to cart...", textVisible: true, textonly: false, html:"" });

		$.ajax({
			url: url,
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(response, status, xhr) {
				$.mobile.loading( "hide" );
				self.requestSuccess(response, status, xhr, self);
			}
		})
	},

	onReduceQtyClick: function (event) {
		var el = $(event.currentTarget),
			rowid = el.attr('data-rowid'),
			url = Chawnow.Constants.url+"/cart/item/reduce-qty/"+rowid,
			self = this;

		$.mobile.loading('show', { text: "Updating cart...", textVisible: true, textonly: false, html:"" });

		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json',
			success: function(response, status, xhr) {
				$.mobile.loading( "hide" );
				self.requestSuccess(response, status, xhr, self);
			}
		});

		event.preventDefault();
	},

	onIncreaseQtyClick: function (event) {
		var el = $(event.currentTarget),
			
			rowid = el.attr('data-rowid'),
			url = Chawnow.Constants.url+"/cart/item/increase-qty/"+rowid,
			self = this;

		$.mobile.loading('show', { text: "Updating cart...", textVisible: true, textonly: false, html:"" });

		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json',
			success: function(response, status, xhr) {
				$.mobile.loading( "hide" );
				self.requestSuccess(response, status, xhr, self);
			}
		});

		event.preventDefault();
	},

	onCheckoutBtnClick: function (event) {
		var url = Chawnow.Constants.url+"/checkout/"+Chawnow.data.restaurant.uid;
		window.location = url;
	},

	requestSuccess: function (response, status, xhr, view) {
		if(response.status == "success") {
			view.renderCartContents(response.contents, response.total);
		}
	},

	renderCartContents: function (contents, total) {
		var template = _.template($('#cart-item-tmpl').html()),
			self = this;
			this.ui.cartcontent.html('');


		_.each(contents, function(content) {
			var model = { rowid: content.rowid, id: content.id, name: content.name, price: content.price, qty: content.qty };
			self.ui.cartcontent.prepend(template(model));
		});

		this.renderTotals(total);
		this.enableCheckoutBtn(total);
	},

	renderTotals: function(cart_total) {
		console.log("Rendering totals");
		var deliveryfee = Number(Chawnow.data.restaurant.delivery_fee);
		var carttotal = Number(cart_total);
		var total = carttotal+deliveryfee;

		var subtotaltmpl = '<li class="sub-total clearfix">'+
						   '<span class="pull-left"><strong>Sub Total</strong></span>'+
						   '<span class="pull-right"><b class="naira">N</b>'+carttotal.toFixed(2)+'</span>'+
						   '</li>';
		var deliverytmp = '<li class="sub-total clearfix">'+
						   '<span class="pull-left">+ Delivery fee</span>'+
						   '<span class="pull-right"><b class="naira">N</b>'+deliveryfee.toFixed(2)+'</span>'+
						   '</li>';
		var totaltmpl = '<li class="sub-total clearfix">'+
						   '<span class="pull-left"><strong>Total</strong></span>'+
						   '<span class="pull-right"><b class="naira">N</b>'+total.toFixed(2)+'</span>'+
						   '</li>';
		if(carttotal > 0) {
			this.ui.cartcontent.append(subtotaltmpl);
			this.ui.cartcontent.append(deliverytmp);
			this.ui.cartcontent.append(totaltmpl);
		}
	},

	enableCheckoutBtn: function(carttotal) {

		var restaurant = Chawnow.data.restaurant;
		//is restaurant open
		if(restaurant.status == 1)
		{
			//is order up to minimium
			var minimium = Number(restaurant.minimium);
			if(carttotal >= minimium)
			{
				//enable btn
				this.ui.checkoutbtn.removeClass('btn-info');
				this.ui.checkoutbtn.addClass('btn-success');
				this.ui.checkoutbtn.removeAttr('disabled');
			}
			else
			{
				//disable btn
				this.ui.checkoutbtn.removeClass('btn-success');
				this.ui.checkoutbtn.addClass('btn-info');
				this.ui.checkoutbtn.attr('disabled','disabled');
			}
		}
	}
});


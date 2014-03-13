Chawnow.Views.RestaurantPage = Backbone.View.extend({
	el: ".restaurant-page",

	events: {
		'click .reduce-qty': 'onReduceQtyClick',
		'click .increase-qty': 'onIncreaseQtyClick',
		'click .checkout-btn': 'onCheckoutBtnClick',
		'click a.menu-category': "onMenuCategoryClick",
		'click .add-to-cart': 'onAddToCartClick'
	},

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
		//render a default menu
		this.renderDefaultMenu();
	},

	ui: {
		'menulist': ".menu-list",
		'itemlist': ".item-list",
		'cart': ".user-cart",
		'cartcontent': ".cart-contents",
		'checkoutbtn': '.checkout-btn'
	},

	renderDefaultMenu: function() {

		var menus = this.ui.menulist;
		var menu = menus.find('li:first a');
		var target = $(menu.attr('data-menu'));

		target.addClass('active');
	},


	renderCartContents: function (contents, total) {

		var template = _.template($('#cart-item-tmpl').html()),
			self = this;
			this.ui.cartcontent.html('');
			this.ui.cartcontent.slideDown();


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
	},

	requestSuccess: function (response, status, xhr, view) {
		if(response.status == "success") {
			view.renderCartContents(response.contents, response.total);
		}
	},

	onReduceQtyClick: function (event) {
		var el = $(event.currentTarget),
			rowid = el.attr('data-rowid'),
			url = Chawnow.Constants.url+"/cart/item/reduce-qty/"+rowid,
			self = this;

		this.ui.cartcontent.slideUp();
		this.ui.cart.find('.loading-indicator').slideDown();

		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json',
			success: function(response, status, xhr) {
				self.ui.cart.find('.loading-indicator').slideUp();
				self.requestSuccess(response, status, xhr, self);
			}
		})
	},

	onIncreaseQtyClick: function (event) {
		var el = $(event.currentTarget),
			rowid = el.attr('data-rowid'),
			url = Chawnow.Constants.url+"/cart/item/increase-qty/"+rowid,
			self = this;

		this.ui.cartcontent.slideUp();
		this.ui.cart.find('.loading-indicator').slideDown();

		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json',
			success: function(response, status, xhr) {
				self.ui.cart.find('.loading-indicator').slideUp();
				self.requestSuccess(response, status, xhr, self);
			}
		})
	},

	onCheckoutBtnClick: function (event) {
		var url = Chawnow.Constants.url+"/checkout/"+Chawnow.data.restaurant.uid;
		window.location = url;
	},

	onMenuCategoryClick: function (event) {
		event.preventDefault();
		var el = $(event.currentTarget);
  		$(el).tab('show');

  		var ul = el.parent('li').parent('ul').parent('li').parent('ul');

		ul.find('li.active').removeClass('active');	
		el.parent('li').addClass('active');
	},

	onAddToCartClick: function (event) {
		var el = $(event.currentTarget),
			itemid = el.attr('data-id'),
			itemname = el.attr('data-item-name'),
			itemprice = el.attr('data-item-price');
			url = Chawnow.Constants.url+"/cart/add",
			data = { id : itemid, name: itemname, price: itemprice , restaurant: Chawnow.data.restaurant.uid },
			self = this;

		this.ui.cartcontent.slideUp();
		this.ui.cart.find('.loading-indicator').slideDown();

		$.ajax({
			url: url,
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(response, status, xhr) {
				self.ui.cart.find('.loading-indicator').slideUp();
				self.requestSuccess(response, status, xhr, self);
			}
		})
		event.preventDefault();
	},

	requestSuccess: function (response, status, xhr, view) {
		if(response.status == "success") {
			view.renderCartContents(response.contents, response.total);
		}
	}
});

$(document).ready(function() {
	var view = new Chawnow.Views.RestaurantPage();
});
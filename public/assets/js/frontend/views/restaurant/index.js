Chawnow.Views.MenuView = Backbone.View.extend({
	tagName: 'li',

	initialize: function(options) {
		this.template = options.template;
		this.parent = options.parent;
	},

	events: {
		'click a.menu':"onMenuClick",
		'click a.menu-category': "onMenuCategoryClick"
	},

	render: function() {
		this.$el.html( this.template( this.model.toJSON() ) );
		return this;
	},

	onMenuClick: function (event) {
		var el = $(event.currentTarget),
			ul = el.parent('li').parent('ul');

		ul.find('li.active').removeClass('active');	
		el.parent('li').addClass('active');

		ul.find('ul.collapse.in').each(function() { $(this).removeClass('in') });

		this.parent.renderMenuItems(this.model);
		event.preventDefault();
	},

	onMenuCategoryClick: function (event) {
		var el = $(event.currentTarget),
			ul = el.parent('li').parent('ul');
			category = el.attr('data-category'),
			menu = ul.attr('data-menu-id');

		ul.find('li.active').removeClass('active');	
		el.parent('li').addClass('active');

		this.parent.renderMenuCategoryItems(category, menu);
		event.preventDefault();
	}
});

Chawnow.Views.ItemView = Backbone.View.extend({
	tagName: 'li',

	initialize: function(options) {
		this.template = options.template;
		this.parent = options.parent;
	},

	events: {
		'click .add-to-cart': 'onAddToCartClick'
	},

	render: function() {
		this.$el.html( this.template( this.model.toJSON() ) );
		return this;
	},

	onAddToCartClick: function (event) {
		var el = $(event.currentTarget),
			itemid = el.attr('data-id'),
			itemname = el.attr('data-item-name'),
			itemprice = el.attr('data-item-price');
			url = Chawnow.Constants.url+"/cart/add",
			data = { id : itemid, name: itemname, price: itemprice , restaurant: Chawnow.data.restaurant.uid },
			self = this;

		this.parent.ui.cartcontent.slideUp();
		this.parent.ui.cart.find('.loading-indicator').slideDown();

		$.ajax({
			url: url,
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(response, status, xhr) {
				self.parent.ui.cart.find('.loading-indicator').slideUp();
				self.requestSuccess(response, status, xhr, self);
			}
		})
		event.preventDefault();
	},

	requestSuccess: function (response, status, xhr, view) {
		if(response.status == "success") {
			view.parent.renderCartContents(response.contents, response.total);
		}
	}
});

Chawnow.Views.RestaurantPage = Backbone.View.extend({
	el: ".restaurant-page",

	events: {
		'click .reduce-qty': 'onReduceQtyClick',
		'click .increase-qty': 'onIncreaseQtyClick',
		'click .checkout-btn': 'onCheckoutBtnClick'
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
		//create collections
		this.menucollection = new Backbone.Collection;
		this.menucollection.comparator = "id";
		this.menuitemcolllection = new Backbone.Collection;
		//bind to collection events
		this.menucollection.on('reset', this.renderMenus, this);
		this.menuitemcolllection.on('reset', this.renderDefaultMenu, this);
		//reset collections
		this.menucollection.reset(Chawnow.data.menus);
		this.menuitemcolllection.reset(Chawnow.data.items);
	},

	ui: {
		'menulist': ".menu-list",
		'itemlist': ".item-list",
		'cart': ".user-cart",
		'cartcontent': ".cart-contents",
		'checkoutbtn': '.checkout-btn'
	},

	/** Collection Methods **/
	renderMenus: function() {
		this.ui.menulist.html('');
		this.menucollection.each(this.renderMenu, this);
	},

	renderMenu: function( menu ) {
		var template = _.template($('#menu-tmpl').html());
		var view = new Chawnow.Views.MenuView({model: menu, template: template, parent: this});
			//render menu
			this.ui.menulist.prepend( view.render().el );
	},

	renderDefaultMenu: function() {
		var listitem = this.ui.menulist.find('li:first a'),
			id = listitem.attr('data-id'),
			menu = this.menucollection.get(id),
			items = this.menuitemcolllection.where({menu_name: menu.get('name')});

		$('.menu-title').text(menu.get('name')).show();
		var ul = listitem.parent('li').find('ul').addClass('in');

		this.ui.itemlist.html('');
		
		_.each(items, this.renderMenuItem, this);
	},

	renderMenuItems: function(menu) {
		var items = this.menuitemcolllection.where({menu_name: menu.get('name')});
		//clear items
		this.ui.itemlist.html('');
		//hide menu title
		$('.menu-title').hide();
		$('.menu-title').text(menu.get('name')).show();

		_.each(items, this.renderMenuItem, this);
	},

	renderMenuItem: function (item) {
		var template = _.template($('#item-tmpl').html());
		var view = new Chawnow.Views.ItemView({model: item, template: template, parent: this});
		//render menu
		this.ui.itemlist.prepend( view.render().el );
	},

	renderMenuCategoryItems: function (categoryname, menu_id) {
		var items = new Array();
		var menu = this.menucollection.get(menu_id);
		var cname;

		_.each(this.menuitemcolllection.models, function(model) {
			var category = model.get('category');
			if(category != null) {
				console.log(category)
				if(category.name == categoryname) {
					items.push(model);
					cname = category.name;
				}
			}
		});

		this.ui.itemlist.html('');
		//hide menu title
		$('.menu-title').hide();
		$('.menu-title').text(menu.get('name')+" - "+cname).show();

		_.each(items, this.renderMenuItem, this);
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
	}
});

$(document).ready(function() {
	var view = new Chawnow.Views.RestaurantPage();
});
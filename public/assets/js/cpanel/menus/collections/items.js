define(['models/item'], function (ItemModel) {
	'use strict';

	var MenuItemCollection = Backbone.Collection.extend({
		model: ItemModel,
		url: Cpanel.Constants.url+"/menus/items"
	});

    return MenuItemCollection;
});
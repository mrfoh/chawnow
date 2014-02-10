define(['models/menu'], function (MenuModel) {
	'use strict';

	var MenuCollection = Backbone.Collection.extend({
		model: MenuModel,
		url: Cpanel.Constants.url+"/menus"
	});

    return MenuCollection;
});
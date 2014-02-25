define(function() {
	'use strict';

	var MenuView = Backbone.View.extend({

		tagName: 'li',

		events: {
			'click .edit-menu': 'onEditMenuClick',
			'click .remove-menu': 'onRemoveMenuClick',
			'click .activate-menu': 'onActivateMenuClick',
			'click .deactivate-menu': 'onDeactivateMenuClick',
			'click .view-menu': 'viewMenuItems',
			'keydown .name-inline-edit': 'updateMenu'
		},

		initialize: function(options) {
			this.template = options.template;
			this.parent = options.parent;
			this.model.on('change', this.render, this);
		},

		render: function() {
			this.$el.html( this.template( this.model.toJSON() ) );
			return this;
		},

		onEditMenuClick: function (event) {
			var el = $(event.currentTarget),
				parent = el.parent('div').parent('div');

			var field = parent.find('input');
			var name = parent.find('.view-menu');

			field.val(name.html());
			name.toggle();

			field.toggle();

			event.preventDefault();
		},

		onRemoveMenuClick: function (event) {
			var el = $(event.currentTarget),
				id = el.attr('data-id'),
				self = this;

				this.model.destroy({
					wait: true,
					success: function (model, response) {
						if(response.status == "success")
							self.remove();
					}
				});

			event.preventDefault();
		},

		onActivateMenuClick: function (event) {
			var el = $(event.currentTarget),
				id = el.attr('data-id'),
				url = Cpanel.Constants.url+"/menus/activate/"+id;
				
				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'json',
					success: function (response, status, xhr) {
						if(response.status == "success") {
							el.attr('class','deactivate-menu');
							el.attr('title','Click to deactivate menu');
							el.find('div.status-icon').removeClass('red').addClass('green');
						}
					}
				})
			event.preventDefault();
		},

		onDeactivateMenuClick: function (event) {
			var el = $(event.currentTarget),
				id = el.attr('data-id'),
				url = Cpanel.Constants.url+"/menus/deactivate/"+id;

				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'json',
					success: function (response, status, xhr) {
						if(response.status == "success") {
							el.attr('class','activate-menu');
							el.attr('title','Click to activate menu');
							el.find('div.status-icon').removeClass('green').addClass('red');
						}
					}
				})
			event.preventDefault();
		},

		viewMenuItems: function (event) {

			var el = $(event.currentTarget),
				name = el.attr('data-slug');

			console.log(name);
			var items = this.parent.$el.find('.menu-item[data-menu-name="'+name+'"]').parent('li'),
				others = this.parent.$el.find('.menu-item').parent('li');

			others.fadeOut();
			items.fadeIn();

			event.preventDefault();
		},

		updateMenu: function (event) {
			var el = $(event.currentTarget),
				id = el.attr('data-id');
			if(event.keyCode == 13)
			{
				el.prop('disabled', true);

				this.model.save({name: el.val() }, {
					wait: true,
					success: function (model, response, options) {
						if(response) {

							el.hide();
							el.prop('disabled', false);
							el.siblings('.view-menu').html(el.val());
							el.siblings('.view-menu').show();
						}
					}
				})
			}
		}
	});

	return MenuView;
});
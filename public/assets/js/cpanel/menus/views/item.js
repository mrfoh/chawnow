define(function() {
	var ItemView = Backbone.View.extend({
		tagName: 'li',

		events: {
			'click .remove-item': 'removeItem',
			'click .edit-item': 'editItem',
			'click .deactivate-item': 'deactivateItem',
			'click .activate-item': 'activateItem'
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

		removeItem: function (event) {
			var el = $(event.currentTarget),
				id = el.attr('data-id');
			var item = this.model;
			var self = this;

			var confirm = window.confirm("Are you sure you want to delete this item");

			if(confirm) {
				this.model.destroy({
					wait: true,
					success: function (model, response) {
						if(response.status == "success")
							self.remove();
					}
				});
			}

			event.preventDefault();
		},

		editItem: function (event) {
			var el = $(event.currentTarget),
				modal = this.parent.$el.find('#menu-item-modal');

				modal.attr('data-mode','edit');
				modal.modal('show');
				modal.attr('data-model-id', this.model.id);

				this.parent.ui.itemname.val(this.model.get('name'));
				this.parent.ui.itemprice.val(this.model.get('price'));

				var menu = this.model.get('menu');
				var category = this.model.get('category');
				var group = this.model.get('group');
				var catid = (category === null) ? 0 : category.id;
				var groupid = (group === null) ? 0: group.id;
				var groups;

				var categories = this.parent.menus.get(menu.id).get('categories');
				_.each(categories, function(category) { if(category.id == catid) groups = category.groups; });

				console.log(groups);

				this.parent.ui.itemmenu.val(menu.id);
				this.parent.ui.itemmenu.select2('val', menu.id);

				this.parent.ui.itemcategory.val(catid);
				this.parent.populateCategories(categories);
					
				this.parent.ui.itemcategory.select2('val', catid);

				this.parent.ui.itemgroup.val(groupid);
				this.parent.populateGroups(groups);

				this.parent.ui.itemgroup.select2('val', groupid);


			event.preventDefault();
		},

		activateItem: function (event) {
			var el = $(event.currentTarget),
				id = el.attr('data-id'),
				url = Cpanel.Constants.url+"/menus/items/activate/"+id;

				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'json',
					success: function (response, status, xhr) {
						if(response.status == "success") {
							el.attr('class','deactivate-item');
							el.attr('title','Click to deactivate item');
							el.find('div.status-icon').removeClass('red').addClass('green');
						}
					}
				});

			event.preventDefault();
		},

		deactivateItem: function (event) {
			var el = $(event.currentTarget),
				id = el.attr('data-id'),
				url = Cpanel.Constants.url+"/menus/items/deactivate/"+id;

				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'json',
					success: function (response, status, xhr) {
						if(response.status == "success") {
							el.attr('class','activate-item');
							el.attr('title','Click to activate item');
							el.find('div.status-icon').removeClass('green').addClass('red');
						}
					}
				});

			event.preventDefault();
		}
	});

	return ItemView;
});
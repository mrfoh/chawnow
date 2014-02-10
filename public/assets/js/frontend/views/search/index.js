Chawnow.Views.Searchpage = Backbone.View.extend({
	el: ".viewport",

	setUpUi: function() {
		var self = this;

		_.each(_.keys(self.ui), function(key) {
			var selector = self.ui[key];
			this.ui[key] = $(selector);
		}, this);
	},

	initialize: function() {

		this.setUpUi();
		this.userFilterOptions();
	},

	userFilterOptions: function() {

		var params = Chawnow.data.search_params;
		//set selected cuisines
		_.each(params.cuisines, this.selectCuisine);
		//set deliveries
		if(params.deliveries == "yes")
			this.ui.deliveries.prop('checked', true);

		if(params.pickups == "yes")
			this.ui.pickups.prop('checked', true);
	},

	selectCuisine: function (cuisine) {

		var id = "#cuisine"+cuisine, field = $(id);
		field.prop('checked', true);
	},

	ui: {
		"form": "#search-form",
		"deliveries": 'input[name="deliveries"]',
		"pickups": 'input[name="pickups"]'
	},

	events: {
		'change input[type="checkbox"]': 'onOptionChange'
	},

	onOptionChange: function (event) {
		this.ui.form.submit();
	}
});
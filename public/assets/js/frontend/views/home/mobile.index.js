Chawnow.Views.Homepage = Backbone.View.extend({
	"el": "#viewport",

	setUpUi: function() {
		var self = this;

		_.each(_.keys(self.ui), function(key) {
			var selector = self.ui[key];
			this.ui[key] = $(selector);
		}, this);
	},

	initialize: function() {
		console.log('initializing view')
		this.setUpUi();
		
		var cities  = Chawnow.data.cities,
		    areas = Chawnow.data.areas;

		this.cities = new Backbone.Collection;
		this.areas = new Backbone.Collection;

		this.cities.on('reset', this.populateCities, this);

		this.cities.reset(cities);
		this.areas.reset(areas);
	},

	events: {
		"click #cities a":'selectCity',
		"click #areas a":'selectArea'
	},

	ui: {
		'cities': '#cities',
		'areas': '#areas'
	},

	selectCity: function (event) {
		var el = $(event.currentTarget),
			name = el.attr('data-name'),
			id = el.attr('data-id'),
			city = $('#city');

		city.val(id);

		el.parent('li').closest('[data-role=listview]').prev('form').find('input').val(name);
    	el.parent('li').closest('[data-role=listview]').children().addClass('ui-screen-hidden');

    	this.populateAreas(name);

		event.preventDefault();
	},

	selectArea: function (event) {

		var el = $(event.currentTarget),
			name = el.attr('data-name'),
			id = el.attr('data-id'),
			city = $('#area');

		city.val(id);

		el.parent('li').closest('[data-role=listview]').prev('form').find('input').val(name);
    	el.parent('li').closest('[data-role=listview]').children().addClass('ui-screen-hidden');

    	event.preventDefault();
	},

	populateCities: function() {

		var template = _.template( $("#item-tmpl").html() ),
					  self = this;

		this.ui.cities.html('');

		this.cities.each(function(city) {
			self.ui.cities.prepend(template(city.toJSON()));
		});

		this.ui.cities.listview('refresh');
	},

	populateAreas: function(name) {
		var template = _.template( $("#item-tmpl").html() );
		var self = this;
		//get city
		var city = this.cities.findWhere({name: name});
		//get areas
		var areas = this.areas.where({city_id: city.id});

		this.ui.areas.html('');
		_.each(areas, function(area) {
			self.ui.areas.prepend(template(area.toJSON()));
		});

		this.ui.areas.listview('refresh');
	}
});
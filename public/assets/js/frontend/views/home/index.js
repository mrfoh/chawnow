Chawnow.Views.Homepage = Backbone.View.extend({
	el: ".viewport",

	events: {
		'typeahead:selected #city-select': 'populateAreas',
		'typeahead:selected #area-select': 'setArea',
		'click .find-btn': 'validateForm'
	},

	initialize: function() {
		var cities  = Chawnow.data.cities,
		    areas = Chawnow.data.areas;

		this.cities = new Backbone.Collection;
		this.areas = new Backbone.Collection;

		this.cities.on('reset', this.populateCities, this);

		this.cities.reset(cities);
		this.areas.reset(areas);
	},

	populateCities: function() {

		var localData = new Array();
		
		this.cities.each(function(city) {
			var datum = {
				value: city.get('name'),
				tokens: [city.get('slug')]
			};

			localData.push(datum);
		});

		$('#city-select').typeahead({
			name: 'cities',
			local: localData
		});
	},

	populateAreas: function (event, datum, name) {
		var el = $(event.currentTarget),
			val = el.val();
		//enable field
		$('#area-select').removeAttr('disabled');
		$('#area-select').find('tt-query, tt-hint').removeAttr('disabled');
		//get city
		var city = this.cities.findWhere({name: val});
		var localData = new Array();
		//set city
		$('#city').val(city.id);
		//get areas
		var areas = this.areas.where({city_id: city.id});
		_.each(areas, function(area) {
			var data = {
				value: area.get('name'),
				tokens: [area.get('slug')]
			};

			localData.push(data);
		});
		//destroy previous typeahead instance
		$('#area-select').typeahead('destroy');
		//create new typeahead instance
		$('#area-select').typeahead({
			name: 'areas',
			local: localData
		});
	},

	setArea: function (event, datum, name) {
		var el = $(event.currentTarget),
			val = el.val();

		var area = this.areas.findWhere({name: val});
		$('#area').val(area.id);
	},

	validateForm: function (event) {

		var city = $("#city-select"),
			area = $("#area-select");

		if(city.val())
		{
			if(area.val())
			{
				return true;
			}
			else
			{
				alert('Please enter your area');
			}
		}
		else
		{
			alert('Please enter your city')
		}
		event.preventDefault();
	}
});
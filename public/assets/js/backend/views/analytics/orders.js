Backend.Views.OrderAnalyticsView = Backbone.View.extend({
	el: "#order-analytics",

	ui: {
		'chart': "#order-chart"
	},

	setUpUi: function() {
		var self = this;

		_.each(_.keys(self.ui), function(key) {
		    var selector = self.ui[key];
		    this.ui[key] = $(selector);
		}, this);

	},

	initialize: function() {

		this.setUpUi();
		this.drawCharts();
	},

	drawCharts: function() {

		var chartdata = new Array();

		_.each(Backend.data.orders.month, function (row) {

			var datarow = { day: row.day, value: row.orders};
			chartdata.push(datarow);
		});

		console.log(chartdata);

		var chart = Morris.Area({
		  element: 'order-chart',
		  data: chartdata,
		  // The name of the data record attribute that contains x-values.
		  xkey: 'day',
		  // A list of names of data record attributes that contain y-values.
		  ykeys: ['value'],
		  // Labels for the ykeys -- will be displayed when you hover over the
		  // chart.
		  labels: ['Orders'],
		  lineColors:['#0090d9'],
		  lineWidth:'0',
		  grid:'false',
		  fillOpacity:'0.5'
		});
	}
});
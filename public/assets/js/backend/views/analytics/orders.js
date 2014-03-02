Backend.Views.OrderAnalyticsView = Backbone.View.extend({
	el: "#order-analytics",

	ui: {
		'orderoverview': "#order-chart",
		'orderdistribution': "#order-distribution"
	},

	events: {
		'click .change-data': 'changeData'
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

		//draw default overiew chart (month)
		var overviewdata = this.formatOrderOverviewData(Backend.data.orders.month);
		this.drawOverviewChart(overviewdata);
		//draw default distribution chart (month)
		var distributiondata = this.formatDistributionData(Backend.data.distribution.month);
		this.drawDistributionChart(distributiondata);
	},

	formatOrderOverviewData: function(data) {
		var chartdata = new Array();

		_.each(data, function (row) {
			var datarow = { day: row.day, value: row.orders};
			chartdata.push(datarow);
		});

		return chartdata;
	},

	formatDistributionData: function(data) {

		var chartdata = [
			{ label: 'Fulfilled Orders', value: data.fulfilled},
			{ label: 'Verified Orders', value: data.verified },
			{ label: 'Placed Orders', value: data.placed }
		];

		return chartdata;
	},

	drawOverviewChart: function( chartdata ) {

		this.ui.orderoverview.html('');

		var chart = Morris.Area({
			element: 'order-chart',
			data: chartdata,
			xkey: 'day',
			ykeys: ['value'],
			labels: ['Orders'],
			lineColors:['#0090d9'],
			lineWidth:'0',
			grid:'false',
			fillOpacity:'0.5'
		});
	},

	drawDistributionChart: function (chartdata) {

		this.ui.orderdistribution.html('');

		var chart = Morris.Donut({
		  element: 'order-distribution',
		  data: chartdata,
		  colors:['#60bfb6','#91cdec','#eceff1']
		});
	},

	changeData: function (event) {

		var el = $(event.currentTarget),
		    parent = el.parent('div.btn-group'),
			range = el.attr('data-value');

		parent.find('button.active').removeClass('active');
		el.addClass('active');

		if(range == "month")
			var data = this.formatOrderOverviewData(Backend.data.orders.month);
		else if(range == "week")
			var data = this.formatOrderOverviewData(Backend.data.orders.week);
		else if(range == "day")
			var data = this.formatOrderOverviewData(Backend.data.orders.day);

		this.drawOverviewChart(data);


	}
});
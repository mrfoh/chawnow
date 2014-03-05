define(function() {
	var OrdersView = Backbone.View.extend({
		el: "#analytics-app",

		queryUrl: Cpanel.Constants.url+"/analytics/orders/query",
		distUrl: Cpanel.Constants.url+"/analytics/orders/distribution",

		statuses: { "all": "All Orders", "fulfilled": "Fulfilled Orders", "verified": "Verified Orders", "placed": "Placed Orders"},

		ui: {
			'overviewchart': '#order-overview-chart',
			'overviewLoading': '#overview .loading-screen',
			'overviewNoData': '#overview .no-data-screen',
			'distributionchart': '#distribution-chart'
		},

		events: {
			'click #overview .change-data': 'changeDatadataRange',
			'click .data-sets a': 'changeDataSet',
			'click #distribution .change-data': 'changeDistrubtionDataRange'
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
			console.log('Starting view: OrdersView');

			//Default overview chart data (month)
			var overviewdata = this.formatOrderData(Cpanel.data.orders);
			//Draw default overview chart
			this.drawOverviewChart(overviewdata);

			//Default distribution data(month)
			var distdata = this.formatDistributionData(Cpanel.data.distribution);
			//Draw default distribution chart
			this.drawDistributionChart(distdata);
			this.renderDistributionFigures(Cpanel.data.distribution);
		},

		formatOrderData: function(data) {
			var chartdata = new Array();

			_.each(data, function (row) {
				var datarow = { day: row.day, value: row.orders};
				chartdata.push(datarow);
			});

			return chartdata;
		},

		formatDistributionData: function(data) {

			 var chartdata = [
			 	{ label: "Fulfilled Orders", value: data.fulfilled },
			 	{ label: "Verified Orders", value: data.verified },
			 	{ label: "Placed Orders", value: data.placed }
			 ];

			 return chartdata;
		},

		drawOverviewChart: function(chartdata) {

			if(chartdata.length > 0) {
				//clear previous chart
				this.ui.overviewchart.html('');
				this.ui.overviewNoData.slideUp();

				var chart = Morris.Area({
					element: 'order-overview-chart',
					data: chartdata,
					xkey: 'day',
					ykeys: ['value'],
					labels: ['Orders'],
					lineColors:['#0090d9'],
					lineWidth:'0',
					grid:'false',
					fillOpacity:'0.5'
				});
			}
			else {
				//show no data screen
				this.ui.overviewchart.slideUp();
				this.ui.overviewNoData.slideDown();
			}
		},

		drawDistributionChart: function(chartdata) {

			this.ui.distributionchart.html('');

			var chart = Morris.Donut({
				element: 'distribution-chart',
				data: chartdata,
				colors:['#60bfb6','#91cdec','#eceff1']
			});
		},

		renderDistributionFigures: function(chartdata) {

			var list = $('.distribution-break-down'), self = this;

			_.each(_.keys(self.statuses), function(key) {
				var element = 'li.'+key;
				var count = chartdata[key];

				list.find(element).find('h3.count').html(count);
			});
		},

		/** UI Event Handlers **/

		changeDatadataRange: function (event) {

			var el = $(event.currentTarget),
				range = el.attr('data-value'),
				status = this.ui.overviewchart.attr('data-status'),
				parent = el.parent('div.btn-group'),
				self = this;

			parent.find('button.active').removeClass('active');
			el.addClass('active');

			//show loading screen
			this.ui.overviewchart.slideUp();
			this.ui.overviewLoading.slideDown();

			//make ajax request
			$.ajax({
				url: self.queryUrl,
				data: { "range": range, "status": status },
				dataType: 'json',
				async: false,
				success: function (response, status, xhr) {
					self.queryRequestSuccess(response, status, xhr, self);
				},
				error: function(i, j, k) {
					console.log(arguments);
				}
			})
		},

		changeDataSet: function (event) {

			var el = $(event.currentTarget),
				status = el.attr('data-value'),
				range = this.ui.overviewchart.attr('data-range'),
				grandparent = el.parent('li').parent('ul'),
				parent = el.parent('li'),
				indicator = $('.current-overview-data-status');
				self = this;

			grandparent.find('li.active').removeClass('active');	
			parent.addClass('active');

			indicator.html(this.statuses[status]);

			//make ajax request
			$.ajax({
				url: self.queryUrl,
				data: { "range": range, "status": status },
				dataType: 'json',
				async: false,
				success: function (response, status, xhr) {
					self.queryRequestSuccess(response, status, xhr, self);
				},
				error: function(i, j, k) {
					console.log(arguments);
				}
			})

			event.preventDefault()
		},

		changeDistrubtionDataRange: function (event) {
			var el = $(event.currentTarget),
				range = el.attr('data-value'),
				parent = el.parent('div.btn-group'),
				self = this;

			parent.find('button.active').removeClass('active');
			el.addClass('active');

			//make ajax request
			$.ajax({
				url: self.distUrl,
				data: { "range": range },
				dataType: 'json',
				async: false,
				success: function (response, status, xhr) {
					self.distributionRequestSuccess(response, status, xhr, self);
				},
				error: function(i, j, k) {
					console.log(arguments);
				}
			})
		},

		/** Callback methods **/
		queryRequestSuccess: function (response, status, xhr, view) {
			if(response.data) {
				var data = view.formatOrderData(response.data);

				view.drawOverviewChart(data);

				view.ui.overviewLoading.slideUp();

				view.ui.overviewchart.attr('data-status', response.params.status);
				view.ui.overviewchart.attr('data-range', response.params.range);
			}
		},

		distributionRequestSuccess: function (response, status, xhr, view) {
			if(response.data) {

				var data = view.formatDistributionData(response.data);

				view.drawDistributionChart(data);
				view.renderDistributionFigures(response.data);

				view.ui.distributionchart.attr('data-range', response.params.range);
			}
		},
	});

	return OrdersView;
})	
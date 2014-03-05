@section('title')
{{ $restaurantData->name }} | Analytics | Orders
@stop

@section('scripts')
{{ HTML::script('assets/js/plugins/raphael.min.js') }}
{{ HTML::script('assets/js/plugins/morris.min.js') }}
<script type="text/javascript">
Cpanel.data = {
	orders: {{ json_encode($orders) }},
	distribution: {{ json_encode($distribution) }}
};
</script>
<script type="text/javascript" src="/assets/js/libs/require.js" data-main="/assets/js/cpanel/analytics/start"></script>
@stop

@section('content')
<div class="page-title">
	<h4>{{ $restaurantData->name }} - Analytics</h4>
</div>

<div class="row-fluid" id="analytics-app">
	 
	<div class="span12" id="order-overview">
		<div class="grid simple" id="overview">
			<div class="grid-title clearfix">
				<h4 class="pull-left">Order Overview</h4>
				<div class="pull-right">
					<div class="btn-group date-range-picker">
						<button class="change-data btn-small btn btn-white active" data-value="month" type="button">Month</button>
						<button class="change-data btn-small btn btn-white" data-value="week" type="button">Week</button>
					</div>
				</div>
			</div>

			<div class="grid-body no-border">
				<div class="clearfix">
					<div class="pull-left">
						<div class="btn-group">
							<button type="button" class="btn btn-small btn-white btn-demo-space current-overview-data-status">All Orders</button>
							<button type="button" class="btn btn-small btn-white dropdown-toggle btn-demo-space" data-toggle="dropdown"><span class="caret"></span></button>
		                    <ul class="dropdown-menu data-sets">
		                      <li class="active"><a href="#" data-value="all">All Orders</a></li>
		                      <li><a href="#" data-value="fulfilled">Fufilled Orders</a></li>
		                      <li><a href="#" data-value="verified">Verified Orders</a></li>
		                      <li><a href="#" data-value="placed">Placed Orders</a></li>
		                    </ul>
                  		</div>
					</div>
				</div>
				<div id="order-overview-chart" data-status="all" data-range="month"></div>
				<div class="loading-screen">
					<div class="loader">
						<p>Loading data, please wait...</p>
					</div>
				</div>

				<div class="no-data-screen">
					<div class="message-box">
						<p><i class="icon-warning-sign"></i> Sorry no data to display</p>
					</div>
				</div>
			</div>
		</div>

		<div class="grid simple" id="distribution">
			<div class="grid-title clearfix">
				<h4 class="pull-left">Order Distribution</h4>
				<div class="pull-right">
					<div class="btn-group date-range-picker">
						<button class="change-data btn btn-small btn-white active" data-value="month" type="button">Month</button>
						<button class="change-data btn btn-small btn-white" data-value="week" type="button">Week</button>
					</div>
				</div>
			</div>

			<div class="grid-body clearfix">
				<div class="pull-left" style="width:50%">
					<ul class="distribution-break-down clearfix">
						<li class="all">
							<p class="label">Orders</p>
							<h3 class="count"></h3>
						</li>
						<li class="fulfilled">
							<p class="label label-success">Fulfilled Orders</p>
							<h3 class="count"></h3>
						</li>
						<li class="verified">
							<p class="label label-info">Verified Orders</p>
							<h3 class="count"></h3>
						</li>
						<li class="placed">
							<p class="label">Placed Orders</p>
							<h3 class="count"></h3>
						</li>
					</ul>
				</div>

				<div class="pull-right" style="width:50%">
					<div id="distribution-chart" data-range="month" style="height: 250px;"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
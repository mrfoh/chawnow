@section('title')
Admin | Analytics | Orders
@stop

@section('scripts')
{{ HTML::script('assets/js/plugins/raphael.min.js') }}
{{ HTML::script('assets/js/plugins/morris.min.js') }}
{{ HTML::script('assets/js/backend/views/analytics/orders.js') }}
<script type="text/javascript">
Backend.data = { 
	orders: { 
		month: {{ json_encode($orders['month']) }},
		week: {{ json_encode($orders['week']) }}
	},

	distribution: {
		month: {{ json_encode($orderDistribution['month']) }},
		week: {{ json_encode($orderDistribution['week']) }}
	}
};
$(document).ready(function (){
	var View = new Backend.Views.OrderAnalyticsView();
});
</script>
@stop

@section('content')
<div class="page-title"><h3>Analytics - Orders</h3></div>

<div class="row-fluid" id="order-analytics">

	<div class="span12">

		<div class="grid simple">
			<div class="grid-title clearfix">
				<h4 class="pull-left">Orders Overview</h4>
				<div class="pull-right">
					<div class="btn-group">
						<button class="change-data btn btn-white active" data-value="month" type="button">Month</button>
						<button class="change-data btn btn-white" data-value="week" type="button">Week</button>
						<!--<button class="change-data btn btn-white" data-value="day" type="button">Day</button>-->
					</div>
				</div>
			</div>

			<div class="grid-body">
				<div class="clearfix">
					<div class="pull-left">
						<div class="btn-group">
							<a class="btn btn-white dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#"> All Orders <span class="caret"></span> </a>
		                    <ul class="dropdown-menu">
		                      <li class="active"><a href="#">All Orders</a></li>
		                      <li><a href="#">Fufilled Orders</a></li>
		                      <li><a href="#">Verified Orders</a></li>
		                      <li><a href="#">Placed Orders</a></li>
		                    </ul>
                  		</div>
					</div>
				</div>

				<div id="order-chart"></div>
			</div>
		</div>

	</div>

	<div class="span6">
		<div class="grid simple">
			<div class="grid-body">
				<div style="height: 200px;" id="order-distribution"></div>
			</div>
		</div>
	</div>
</div>
@stop
@section('title')
{{ $restaurantData->name }} | Dashboard 
@stop

@section('content')
<div class="page-title">
	<h4>Dashboard</h4>
</div>

<div class="row-fluid" id="dashboard">
@if(!$setupProgress['menusCreated'])
	<div class="span6">
		<div class="grid simple vertical-green call-to-action">
			<div class="grid-body">
				<div class="clearfix">
					<div class="pull-left image">
						<a href="#"><i class="icon-paste icon-4x icon-border"></i></a>
					</div>

					<div class="pull-left text">
						<h3>No menus created yet</h3>
						<p>You have not created any menus <br/> for your customers to order from.</p>
						<a href="/menus" class="btn btn-large btn-success">Create menus</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endif

@if(!$setupProgress['menuItemsCreated'])
	<div class="span6">
		<div class="grid simple vertical-green call-to-action">
			<div class="grid-body">
				<div class="clearfix">
					<div class="pull-left image">
						<a href="#"><i class="icon-paste icon-4x icon-border"></i></a>
					</div>

					<div class="pull-left text">
						<h3>No menu items created yet</h3>
						<p>You have created any items for your menus. <br/> Add items for your customers to order.</p>
						<a href="/menus" class="btn btn-large btn-success">Create items</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endif
	<!--
	<div class="span4">
		<div class="tiles blue added-margin">
			<div class="tiles-body">
				<div class="tiles-title">TODAY'S ORDERS</div>
				<div class="heading">
					<span class="animate-number" data-value="50" data-animation-duration="1000">0</span> Orders	
				</div>
			</div>
		</div>
	</div>

	<div class="span4">
		<div class="tiles red added-margin">
			<div class="tiles-body">
				<div class="tiles-title">TODAY'S VERIFIED ORDERS</div>
				<div class="heading">
					<span class="animate-number" data-value="35" data-animation-duration="1000">0</span> Orders
				</div>
			</div>
		</div>
	</div>

	<div class="span4">
		<div class="tiles green added-margin">
			<div class="tiles-body">
				<div class="tiles-title">TODAY'S FUFILLED ORDERS</div>
				<div class="heading">
					<span class="animate-number" data-value="30" data-animation-duration="1000">0</span> Orders
				</div>
			</div>
		</div>
	</div>

	<div class="span6 offset3" style="margin-top: 20px;">
		<div class="tiles white added-margin">
			<div class="tiles-body">
				<div class="tiles-title">NEW ORDERS</div>
				<br>
				<div class="notification-messages info clearfix">
					<div class="message-wrapper">
						<div class="heading">New order from - John Doe</div>
						<div class="description">1 x Pepperoni Pizza, 3 x Burgers</div>
					</div>
					<div class="date pull-right">5 Minutes ago</div>
				</div>

				<div class="notification-messages info clearfix">
					<div class="message-wrapper">
						<div class="heading">New order from - Jane Smith</div>
						<div class="description">1 x Pepperoni Pizza</div>
					</div>
					<div class="date pull-right">10 Minutes ago</div>
				</div>

				<div class="notification-messages info clearfix">
					<div class="message-wrapper">
						<div class="heading">New order from - Mike Tyson</div>
						<div class="description">1 x Pepperoni Pizza</div>
					</div>
					<div class="date pull-right">20 Minutes ago</div>
				</div>
			</div>
		</div>
	</div>
	-->
</div>
@stop
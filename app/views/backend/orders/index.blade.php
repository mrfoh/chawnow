@section('title')
Admin | Orders
@stop

@section('scripts')
@stop

@section('content')
<div class="page-title">
	<h4>Restaurant Orders</h4>
</div>

<div class="row-fluid" id="orders-app">
	<div class="span12">
		<ul class="nav nav-tabs">
			<li class="{{ ($status == 'all') ? 'active' : '' }}"><a href="/orders/all">All Orders</a></li>
			<li class="{{ ($status == 'placed') ? 'active' : '' }}"><a href="/orders/placed">Placed Orders</a></li>
			<li class="{{ ($status == 'verified') ? 'active' : '' }}"><a href="/orders/verified">Verified Orders</a></li>
			<li class="{{ ($status == 'fulfilled') ? 'active' : '' }}"><a href="/orders/fulfilled">Fulfilled Orders</a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active">
			@if($orders->getTotal() < 1)
				<div class="empty">
					<h3>No orders to display</h3>
				</div>
			@else
				<table class="table table-hover no-more-tables">
					<thead>
						<tr>
							<th>Order #</th>
							<th>Restaurant</th>
							<th>Customer</th>
							<th>Status</th>
							<th>Created At</th>
							<th>Expected By</th>
							<th>Type</th>
							<th>Order Value</th>
						</tr>
					</thead>
					<tbody>
					@foreach($orders as $order)
						<tr>
							<td><a href="/orders/view/{{ $order->id }}">{{ $order->id }}</a></td>
							<td>{{ $order->restaurant->name }}</td>
							<td>{{ $order->customer_name }}</td>
							<td>{{ ucwords($order->status) }}</td>
							<td>
								{{ date("h:i A" , strtotime($order->created_at)) }}<br>
								  {{ date("Y/m/d" , strtotime($order->created_at)) }}
							</td>
							<td>
								<strong>{{ date("h:i A" , strtotime($order->eta)) }}</strong><br>
								  {{ date("Y/m/d" , strtotime($order->eta)) }}
							</td>
							<td>{{ ucwords($order->type) }}</td>
							<td><b class="naira">N</b>{{ number_format($order->total['total'], 2) }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>

				{{ $orders->links() }}
			@endif
			</div>
		</div>
	</div>
</div>
@stop
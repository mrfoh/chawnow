@section('title')
My Orders | Chawnow | Online Food Ordering
@stop

@section('content')
<div class="page" id="orders-page">

	<div class="order-page-header">
		My Orders
	</div>

	@if($orders->getTotal() > 0)
		<ul class="order-list" data-role="listview" data-inset="false">
		@foreach($orders as $order)
		<li><a href="/account/orders/{{ $order->id }}" data-ajax="false">
			<h2>Order #{{ $order->id }}</h2>
			<p><strong>Placed At: </strong>{{ date("h:i A", strtotime($order->created_at)) }}, {{ date("Y/m/d", strtotime($order->created_at)) }}</p>
			<p><strong>Restaurant: </strong>{{ $order->restaurant->name }}</p>
			<p><strong>Order Value: </strong><b class="naira">N</b>{{ number_format($order->total['total'], 2) }}</p>
			@if($order->status == "placed")
			<p class="ui-li-aside">{{ ucwords($order->status) }}</p>
			@elseif($order->status == "verified")
			<p class="ui-li-aside">{{ ucwords($order->status) }}</p>
			@elseif($order->status == "fulfilled")
			<p class="ui-li-aside">{{ ucwords($order->status) }}</p>
			@endif
		</a>
		</li>
		@endforeach	
		</ul>
	@else
		<div class="empty">
			<h3>You have not placed any orders</h3>
			<a href="/" class="btn btn-warning btn-lg">Find some food</a>
		</div>
	@endif
</div>
@stop
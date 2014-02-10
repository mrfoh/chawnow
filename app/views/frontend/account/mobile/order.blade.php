@section('title')
Order #{{ $order->id }} | Chawnow | Online Food Ordering
@stop

@section('content')
<div class="page" id="orders-page">
	<div class="order-page-header">
		Order #{{ $order->id }}
	</div>

	<div class="order">
		<div class="order-meta">
			<p><strong>Placed At: </strong>{{ date("h:i A", strtotime($order->created_at)) }}, {{ date("Y/m/d", strtotime($order->created_at)) }}</p>
			<p><strong>Placed To: </strong>{{ $order->restaurant->name }}</p>
			<p><strong>Order Type: </strong>{{ ucwords($order->type) }}</p>
			<p><strong>Order Value: </strong><b class="naira">N</b>{{ number_format($order->total['total'], 2) }}</p>
		</div>

		<div class="order-customer">
			<address>
				{{ $order->customer_address }}, <br/>
				{{ $order->restaurant->area->name }}, {{ $order->restaurant->city->name }}. <br/>
				<abbr title="Phone">P:</abbr> {{ $order->customer_phone }} <br/>
				<abbr title="Email Address">E:</abbr> {{ $order->customer_email }}
			</address>
		</div>

		<div class="order-detail">
			<ul class="order-items">
				@foreach($order->items as $orderitem)
				<li class="clearfix ui-shadow">
					<div class="pull-left name">
						{{ $orderitem->item->name }}<br/>
						<b class="naira">N</b>{{ number_format($orderitem->item->price, 2) }}
					</div>
					<div class="pull-right qty">
						<a href="#" class="ui-btn ui-mini ui-btn-inline qty">{{ $orderitem->qty }}</a>
					</div>
				</li>
				@endforeach
				<li class="sub-total clearfix">
					<span class="pull-left"><strong>Sub Total</strong></span>
					<span class="pull-right"><b class="naira">N</b>{{ number_format($order->total['subtotal'], 2) }}</span>
				</li>
				@if($order->type == "delivery")
				<li class="sub-total clearfix">
					<span class="pull-left">+ Delivery Fee</span>
					<span class="pull-right"><b class="naira">N</b>{{ number_format($order->restaurant->meta->delivery_fee, 2) }}</span>
				</li>
				@else
				<li class="sub-total clearfix">
					<span class="pull-left">+ Delivery Fee</span>
					<span class="pull-right"><b class="naira">N</b>0.00</span>
				</li>
				@endif
				<li class="sub-total clearfix">
					<span class="pull-left"><strong>Total</strong></span>
					<span class="pull-right"><b class="naira">N</b>{{ number_format($order->total['total'], 2) }}</span>
				</li>
			</ul>
		</div>

		<div class="order-actions clearfix" style="padding: .5em">
			@if($order->status == "fulfilled")
				<a href="/account/orders/{{ $order->id }}/reorder" class="ui-btn btn-success" data-ajax="false">Reorder</a>
			@endif
		</div>
	</div>
</div>
@stop
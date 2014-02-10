@section('title')
Order #{{ $order->id }} | Chawnow | Online Food Ordering
@stop

@section('page_class') account-page @stop

@section('content')
<div class="page-content container">
	<div class="row">
		<div class="col-md-4 account-page-sidebar">
			<div class="card">
				<ul>
					<li><a href="/account">My Account</a></li>
					<li class="active"><a href="/account/orders">My Orders</a></li>
					<li><a href="/account/addresses">My Addresses</a></li>
					<li><a href="/account/password">Change Password</a></li>
				</ul>
			</div>
		</div>

		<div class="col-md-8 account-page-content">
			<div class="card order">
				<div class="card-header">Order #{{ $order->id }}</div>
				<div class="card-content">
					<div class="clearfix" style="padding: 10px;">
						<div class="pull-left">
							<h3>Customer Info</h3>
							<address>
								{{ $order->customer_address }}, <br/>
								{{ $order->restaurant->area->name }}, {{ $order->restaurant->city->name }}. <br/>
								<abbr title="Phone">P:</abbr> {{ $order->customer_phone }} <br/>
								<abbr title="Email Address">E:</abbr> {{ $order->customer_email }}
							</address>
						</div>

						<div class="pull-right">
							<p><strong>Placed At: </strong>{{ date("h:i A", strtotime($order->created_at)) }}, {{ date("Y/m/d", strtotime($order->created_at)) }}</p>
							<p><strong>Placed To: </strong>{{ $order->restaurant->name }}</p>
							<p><strong>Order Type: </strong>{{ ucwords($order->type) }}</p>
							<p><strong>Order Value: </strong><b class="naira">N</b>{{ number_format($order->total['total'], 2) }}</p>
						</div>
					</div>

					<table class="table" style="padding: 10px;">
						<thead>
							<tr>
			                  <th>Quantity</th>
			                  <th>Item Name</th>
			                  <th>Unit Price</th>
			                  <th>Total</th>
			                </tr>
		                </thead>
		                <tbody>
		                @foreach($order->items as $orderitem)
		              	  <tr>
		              	  	  <td>{{ $orderitem->qty }}</td>
			                  <td>{{ $orderitem->item->name }}</td>
			                  <td><b class="naira">N</b>{{ number_format($orderitem->item->price, 2) }}</td>
			                  <td><b class="naira">N</b>{{ number_format(($orderitem->item->price*$orderitem->qty), 2) }}</td>
		              	  </tr>
		                @endforeach
			                <tr>
			                  <td colspan="2" rowspan="4"><h4 class="semi-bold">Customers Comments</h4>
			                    <p>{{ $order->comments }}.</p>
			                  <td><strong>Subtotal</strong></td>
			                  <td><b class="naira">N</b>{{ number_format($order->total['subtotal'], 2) }}</td>
			                </tr>
			                @if($order->type == "delivery")
			                <tr>
			                  <td><strong>Delivery Fee</strong></td>
			                  <td><b class="naira">N</b>{{ number_format($order->restaurant->meta->delivery_fee, 2) }}</td>
			                </tr>
			                @else
			                <tr>
			                  <td><strong>Delivery Fee</strong></td>
			                  <td><b class="naira">N</b>0.00</td>
			                </tr>
			                @endif
			                <tr>
			                  <td><div class="well well-small green"><strong>Total</strong></div></td>
			                  <td><strong><b class="naira">N</b>{{ number_format($order->total['total'], 2) }}</strong></td>
			                </tr>
		            	</tbody>
					</table>
					<div class="order-actions clearfix">
						@if($order->status == "fulfilled")
						<div style="width: 50%; margin:0 auto; padding: 10px;">
							<a href="/account/orders/{{ $order->id }}/reorder" class="btn btn-block btn-success"><i class="icon-refresh"></i> Reorder</a>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
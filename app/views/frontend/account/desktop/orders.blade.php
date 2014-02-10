@section('title')
My Orders | Chawnow | Online Food Ordering
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
			<div class="card">
				<div class="card-header">My Orders</div>
				<div class="card-content">
				@if($orders->getTotal() > 0)
					<ul class="order-list">
					@foreach($orders as $order)
						<li class="order">
							<div class="order-header clearfix">
								<div class="order-id pull-left"><h4>Order #{{ $order->id }}</h4></div>
								<div class="order-status pull-right">
									@if($order->status == "placed")
									<span class="badge badge-info">{{ ucwords($order->status) }}</span>
									@elseif($order->status == "verified")
									<span class="badge badge-warning">{{ ucwords($order->status) }}</span>
									@elseif($order->status == "fulfilled")
									<span class="badge badge-success">{{ ucwords($order->status) }}</span>
									@endif
								</div>
							</div>
							<div class="order-footer clearfix">
								<div class="pull-left">
									<p><strong>Placed At: </strong>{{ date("h:i A", strtotime($order->created_at)) }}, {{ date("Y/m/d", strtotime($order->created_at)) }}</p>
									<p><strong>Restaurant: </strong>{{ $order->restaurant->name }}</p>
									<p><strong>Order Value: </strong><b class="naira">N</b>{{ number_format($order->total['total'], 2) }}</p>
								</div>
								<div class="pull-right">
									<a href="/account/orders/{{ $order->id }}"><i class="icon-chevron-right icon-4x"></i></a>
								</div>
							</div>
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
			</div>
		</div>
	</div>
</div>
@stop
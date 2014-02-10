@section('title')
Order Complete | Chawnow | Online Food Ordering
@stop

@section('content')
<div class="page" id="order-complete-page">

	<div class="content-box ui-shadow">
			<h3>Order Complete</h3>
			<p>Your order to {{ $restaurant->name }} has successfully verified. <br>
				Your order number: #{{ $order->id }}<br>
				Please keep this order number safe as it will used to resolve issues with your order.
			</p>

			<a href="/" class="ui-btn btn-warning">Find more food</a>
			<p>Thanks for using Chawnow.</p>
		</div>
	</div>
</div>
@stop
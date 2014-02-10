@section('title')
Verfiy Your Order | Chawnow | Online Food Ordering
@stop

@section('page_class') verification-page @stop

@section('description')
Order from the best local restaurants • Select your food from a large choice : pizza, sushi, American food... •  Fast and convenient •  Cash on delivery.
@stop

@section('scripts')
<script type="text/javascript">
Chawnow.data = { orderid: "{{ $order->id }}"};
</script>
{{ HTML::script('assets/js/frontend/views/checkout/verify.js') }}
<script type="text/javascript">
$(document).ready(function() {
	var view = new Chawnow.Views.VerificationPage();
});
</script>
@stop

@section('content')
<div class="page-content container">
	<div class="row">
		<div class="col-md-9 content-box">
			<div class="content-box-header">
				Verify Your Order
			</div>
			<div class="box-content">
				@if($message) <div class="alert alert-info">{{ $message }}</div> @endif
				<p>You have placed an order to {{ $restaurant->name }}. <br>
					In order for the restaurant to process your order, please verify your order by entering
					the verification code sent you via SMS and email.</p>
					<div class="verify-form-box">
					{{ Form::open(array("url"=>"order/".$order->id."/verify", "type"=>"post", "id"=>"verify-form")) }}
						<div class="form-group">
							<label for="code">Verification Code</label>
							<input class="form-control" name="code" id="code" style="width: 50%;">
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-warning verify-btn">Verify Order</button>
						</div>
					{{ Form::close() }}
					</div>
					<a href="/order/{{ $order->id }}/resend-verify">Resend Verification Code</a>
			</div>
		</div>

		<div class="col-md-3 user-cart">
			<div class="cart-header clearfix">
				<div class="pull-left">Your Order</div>
			</div>
			<div class="cart-content">
				<div class="loading-indicator">
				    <i class="icon-spinner icon-spin icon-4x "></i>
				</div>
				@if($cart_contents)
				<ul class="cart-contents" style="display: block;">
					@foreach($cart_contents as $item)
					<li data-rowid="{{ $item['rowid'] }}" class="clearfix">
						<div class="pull-left">
							<div>{{ $item['name'] }}</div>
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-sm qty">{{ $item['qty'] }}</button>
							</div>
						</div>
						<div class="pull-right"><b class="naira">N</b>{{ number_format($item['price'],2) }}</div>
					</li>
					@endforeach
					<li class="sub-total clearfix">
						<span class="pull-left"><strong>Sub Total</strong></span>
						<span class="pull-right cart-total"><b class="naira">N</b>{{ number_format($cart_total,2) }}</span>
					</li>
					<li class="sub-total clearfix">
						<span class="pull-left">+ Delivery Fee</span>
						@if($order->type == "delivery")
						<span class="pull-right delivery-fee"><b class="naira">N</b>{{ number_format($restaurant->meta->delivery_fee,2) }}</span>
						@elseif($order->type == "pickup")
						<span class="pull-right delivery-fee"><b class="naira">N</b>{{ number_format(0,2) }}</span>
						@endif
					</li>
					<li class="sub-total clearfix">
						<span class="pull-left"><strong>Total</strong></span>
						@if($order->type == "delivery")
							<?php $total = $restaurant->meta->delivery_fee + $cart_total; ?>
						<span class="pull-right total"><b class="naira">N</b>{{ number_format($total,2) }}</span>
						@elseif($order->type == "pickup")
						<span class="pull-right total"><b class="naira">N</b>{{ number_format($cart_total,2) }}</span>
						@endif
					</li>
				</ul>
				@endif
			</div>
			<div class="cart-footer">
				@if($order->type == "delivery")
				<p><i class="icon-time"></i> Delivery in: {{ $restaurant->meta->delivery_time }}</p>
				@endif
				@if($order->type == "pickup")
				<p><i class="icon-time"></i> Pickup in: {{ $restaurant->meta->pickup_time }}</p>
				@endif
			</div>
		</div>
	</div>
</div>
@stop
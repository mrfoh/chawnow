@section('title')
Verfiy Your Order | Chawnow | Online Food Ordering
@stop

@section('scripts')
<script type="text/javascript">
Chawnow.data = { orderid: "{{ $order->id }}"};
</script>
{{ HTML::script('assets/js/frontend/views/checkout/mobile.verify.js') }}
<script type="text/javascript">
$(document).ready(function() {
	var view = new Chawnow.Views.VerificationPage();
});
</script>
@stop

@section('content')
<div class="page" id="verify-page">

	<div class="verify-box ui-shadow">
		<h3>Verfiy your order</h3>
		@if($message) <div class="alert alert-info">{{ $message }}</div> @endif
		<p>You have placed an order to {{ $restaurant->name }}. <br>
					In order for the restaurant to process your order, please verify your order by entering
					the verification code sent you via SMS and email.</p>
		{{ Form::open(array("url"=>"order/".$order->id."/verify", "type"=>"post", "id"=>"verify-form", "data-ajax"=>"false")) }}
			<label for="code">Verification Code</label>
			<input type="text" name="code" id="code">
			<button type="submit" class="ui-btn btn-warning verify-btn">Verify Order</button>
		{{ Form::close() }}
		<a href="/order/{{ $order->id }}/resend-verify" data-ajax="false">Resend Verification Code</a>
	</div>
</div>
@stop
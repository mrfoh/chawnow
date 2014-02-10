@section('title')
Checkout Your Order | Chawnow | Online Food Ordering
@stop

@section('scripts')
<script type="text/javascript">
Chawnow.data = {
	restaurant: 
	{ 
		id: {{ $restaurant->id }} ,
	    name: "{{ $restaurant->name }}",
		uid: "{{ $restaurant->slug }}",
		delivery_fee: {{ $restaurant->meta->delivery_fee }},
		minimium: {{ $restaurant->meta->minimium }}
	},
	addressess: {{ json_encode($addressess) }}
};
</script>
{{ HTML::script('assets/js/frontend/views/checkout/mobile.index.js') }}
<script type="text/javascript">
$(document).bind('pageinit', function() {
	var view = new Chawnow.Views.CheckoutPage();
});
</script>
@stop

@section('content')
<div class="page" id="checkout-page">
	<div data-role="tabs">
		<div data-role="navbar">
			<ul class="checkout-nav">
				<li><a href="#details" class="ui-btn-active" data-ajax="false">Customer Details</a></li>
				<li><a href="#order" data-ajax="false">Your Order</a></li>
			</ul>
		</div>

		<div id="details" class="tablist-content">
		{{ Form::open(array('url'=>'checkout/'.$uid, 'method'=> "post","data-ajax"=>"false","id"=>"customer-form")) }}
		@if($isLoggedin)
			<label for="first_name">First Name</label>
			<input class="{{ $errors->has('first_name') ? 'has-error': '' }}" type="text" id="first_name" name="first_name" value="{{ $customer->first_name }}" placeholder="First Name">
			@if($errors->has('first_name'))
				<p class="field-error">{{ $errors->first('first_name') }}</p>
			@endif

			<label for="first_name">Last Name</label>
			<input class="{{ $errors->has('last_name') ? 'has-error': '' }}" type="text" id="last_name" name="last_name" value="{{ $customer->last_name }}" placeholder="Last Name">
			@if($errors->has('first_name'))
				<p class="field-error">{{ $errors->first('last_name') }}</p>
			@endif

			<label for="mobile_no">Mobile Number</label>
			<input class="{{ $errors->has('mobile_no') ? 'has-error': '' }}" type="text" id="mobile_no" name="mobile_no" value="{{ $customer_profile->mobile_no }}" placeholder="Mobile Number">
			@if($errors->has('mobile_no'))
				@foreach($errors->get('mobile_no') as $message)
				<p class="field-error">{{ $message }}</p>
				@endforeach
			@endif

			<label for="email">Email</label>
			<input class="{{ $errors->has('email') ? 'has-error': '' }}" type="email" id="email" name="email" value="{{ $customer->email }}" placeholder="Email Address">
			@if($errors->has('email'))
				@foreach($errors->get('email') as $message)
				<p class="field-error">{{ $message }}</p>
				@endforeach
			@endif

			<label for="street">Address</label>
			<textarea class="{{ $errors->has('street') ? 'has-error': '' }}" id="street" name="street" placeholder="Address"></textarea>
			@if($errors->has('street'))
				<p class="field-error">{{ $errors->first('street') }}</p>
			@endif

			<label for="city">City</label>
			<input type="text" id="city" name="city" value="{{ $city }}" disabled="disabled">

			<label for="city">Area</label>
			<input type="text" id="area" name="area" value="{{ $area }}" disabled="disbaled">

			<label for="comments">Comments/Instructions</label>
			<textarea id="comments" name="comments" placeholder="Additional order instructions/comments"></textarea>

			<fieldset data-role="controlgroup">
    			<legend>Delivery Type:</legend>
    			@if($errors->has('delivery_type'))
				@foreach($errors->get('delivery_type') as $message)
				<p class="field-error">{{ $message }}</p>
				@endforeach
				@endif

    			@if((bool) $restaurant->meta->deliveries)
    			<input type="radio" name="delivery_type" value="delivery" id="delivery_type_delivery">
    			<label for="delivery_type_delivery">Delivery - your meal will be delivered at your chosen address</label>
    			@endif

    			@if((bool) $restaurant->meta->pickups)
    			<input type="radio" name="delivery_type" value="pickup" id="delivery_type_pickup">
    			<label for="delivery_type_pickup">Pick up - pick up your meal at the restaurant</label>
    			@endif
    		</fieldset>
		@else
			<label for="first_name">First Name</label>
			<input class="{{ $errors->has('first_name') ? 'has-error': '' }}" type="text" id="first_name" name="first_name" placeholder="First Name" value="{{ Input::old('first_name') }}">
			@if($errors->has('first_name'))
				<p class="field-error">{{ $errors->first('first_name') }}</p>
			@endif

			<label for="first_name">Last Name</label>
			<input class="{{ $errors->has('last_name') ? 'has-error': '' }}" type="text" id="last_name" name="last_name" placeholder="Last Name" value="{{ Input::old('last_name') }}">
			@if($errors->has('first_name'))
				<p class="field-error">{{ $errors->first('last_name') }}</p>
			@endif

			<label for="mobile_no">Mobile Number</label>
			<input class="{{ $errors->has('mobile_no') ? 'has-error': '' }}" type="text" id="mobile_no" name="mobile_no" placeholder="Mobile Number" value="{{ Input::old('mobile_no') }}">
			@if($errors->has('mobile_no'))
				@foreach($errors->get('mobile_no') as $message)
				<p class="field-error">{{ $message }}</p>
				@endforeach
			@endif

			<label for="email">Email</label>
			<input class="{{ $errors->has('email') ? 'has-error': '' }}" type="email" id="email" name="email" placeholder="Email Address" value="{{ Input::old('email') }}">
			@if($errors->has('email'))
				@foreach($errors->get('email') as $message)
				<p class="field-error">{{ $message }}</p>
				@endforeach
			@endif

			<label for="street">Street Address</label>
			<textarea class="{{ $errors->has('street') ? 'has-error': '' }}" id="street" name="street" placeholder="Address">{{ Input::old('street') }}</textarea>
			@if($errors->has('street'))
				<p class="field-error">{{ $errors->first('street') }}</p>
			@endif

			<label for="city">City</label>
			<input type="text" id="city" name="city" value="{{ $city }}" disabled="disabled">

			<label for="city">Area</label>
			<input type="text" id="area" name="area" value="{{ $area }}" disabled="disabled">

			<label for="comments">Comments/Instructions</label>
			<textarea id="comments" name="comments" placeholder="Additional order instructions/comments"></textarea>

			<fieldset data-role="controlgroup">
    			<legend>Delivery Type:</legend>
    			@if($errors->has('delivery_type'))
				@foreach($errors->get('delivery_type') as $message)
				<p class="field-error">{{ $message }}</p>
				@endforeach
				@endif

    			@if((bool) $restaurant->meta->deliveries)
    			<input type="radio" name="delivery_type" value="delivery" id="delivery_type_delivery">
    			<label for="delivery_type_delivery">Delivery - your meal will be delivered at your chosen address</label>
    			@endif

    			@if((bool) $restaurant->meta->pickups)
    			<input type="radio" name="delivery_type" value="pickup" id="delivery_type_pickup">
    			<label for="delivery_type_pickup">Pick up - pick up your meal at the restaurant</label>
    			@endif
    		</fieldset>
		@endif

		<div class="order-total clearfix">
			<div class="pull-left"><strong>Total</strong></div>
			<div class="pull-right grand-total"><b class="naira">N</b>{{ number_format($total,2) }}</div>
		</div>

		<button type="submit" class="ui-btn order-btn">Place Order</button>
		{{ Form::close() }}
		</div>

		<div id="order" class="tablist-content">
			@if($cart_contents)
				<ul class="cart-contents user-cart">
					@foreach($cart_contents as $item)
					<li data-rowid="{{ $item['rowid'] }}" class="clearfix ui-shadow">
						<div class="pull-left name">
							{{ $item['name'] }}<br>
							<b class="naira">N</b>{{ number_format($item['price'],2) }}
						</div>
						<div class="pull-right qty">
							<a href="#" class="ui-btn ui-btn-inline ui-icon-carat-d ui-btn-icon-notext reduce-qty" data-rowid="{{ $item['rowid'] }}"></a>
							<a href="#" class="ui-btn ui-mini ui-btn-inline qty">{{ $item['qty'] }}</a>
							<a href="#" class="ui-btn ui-btn-inline ui-icon-carat-u ui-btn-icon-notext increase-qty" data-rowid="{{ $item['rowid'] }}"></a>
						</div>
					</li>
					@endforeach
					<li class="sub-total clearfix">
						<span class="pull-left"><strong>Sub Total</strong></span>
						<span class="pull-right cart-total" data-value="{{ $cart_total }}"><b class="naira">N</b>{{ number_format($cart_total,2) }}</span>
					</li>
					<li class="sub-total clearfix">
						<span class="pull-left">+ Delivery Fee</span>
						<span class="pull-right delivery-fee" data-value="{{ $restaurant->meta->delivery_fee }}"><b class="naira">N</b>{{ number_format($restaurant->meta->delivery_fee,2) }}</span>
					</li>
					<li class="sub-total clearfix">
						<span class="pull-left"><strong>Total</strong></span>
						<span class="pull-right total" data-value="{{ $total }}"><b class="naira">N</b>{{ number_format($total,2) }}</span>
					</li>
				</ul>
			@else
				<ul class="cart-contents"></ul>
			@endif
		</div>
	</div>
</div>
@stop
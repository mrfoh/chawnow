@section('title')
Checkout Your Order | Chawnow | Online Food Ordering
@stop

@section('page_class') checkout-page @stop

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
<script type="text/template" id="address-box-tmpl">
<div class="address-box-header">My Addressess</div>
<div class="address-box-body">
	<p>Click on an address to select it</p>
	<ul class="addressess"></ul>
</div>
</script>
<script type="text/template" id="address-tmpl">
<li class="user-address"><a href="" data-text="<%= text %>"><%= name %> - <%= text %></a></li>
</script>
{{ HTML::script('assets/js/frontend/views/checkout/index.js') }}
@stop

@section('content')
<div class="page-content container">
	<div class="row">
		<div class="col-md-9 checkout-content">
		@if($isLoggedin)
			<div class="customer-details">
				<h3>Customer Details</h3>
				{{ Form::open(array('url'=>'checkout/'.$uid, 'method'=> "post","class"=>"form-horizontal")) }}
				<div class="inner">
					<div class="form-group {{ $errors->has('first_name') ? 'has-error': '' }}">
						<label for="first_name" class="col-sm-3 control-label">First Name</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ $customer->first_name }}">
					      @if($errors->has('first_name'))
					      	<p class="help-block">{{ $errors->first('first_name') }}</p>
					      @endif
					    </div>
					</div>

					<div class="form-group {{ $errors->has('last_name') ? 'has-error': '' }}">
						<label for="last_name" class="col-sm-3 control-label">Last Name</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{ $customer->last_name }}">
					      @if($errors->has('last_name'))
					      	<p class="help-block">{{ $errors->first('last_name') }}</p>
					      @endif
					    </div>
					</div>

					<div class="form-group {{ $errors->has('mobile_no') ? 'has-error': '' }}">
						<label for="mobile_no" class="col-sm-3 control-label">Mobile Number</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile Number" value="{{ $customer_profile->mobile_no }}">
					      @if($errors->has('mobile_no'))
					      @foreach($errors->get('mobile_no') as $message)
					      <p class="help-block">{{ $message }}</p>
					      @endforeach
					      @endif
					    </div>
					</div>

					<div class="form-group {{ $errors->has('email') ? 'has-error': '' }}">
						<label for="mobile_no" class="col-sm-3 control-label">Email</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="{{ $customer->email }}">
					       @if($errors->has('email'))
					      @foreach($errors->get('email') as $message)
					      <p class="help-block">{{ $message }}</p>
					      @endforeach
					      @endif
					    </div>
					</div>

					<div class="form-group {{ $errors->has('street') ? 'has-error': '' }}">
						<label for="street" class="col-sm-3 control-label">Street</label>
					    <div class="col-sm-7 address-box">
					      <input type="text" class="form-control" id="street" name="street" placeholder="Street address">
					       @if($errors->has('last_name'))
					      	<p class="help-block">{{ $errors->first('street') }}</p>
					      @endif
					    </div>
					</div>

					<div class="form-group">
						<label for="city" class="col-sm-3 control-label">City</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="city" name="city" disabled value="{{ $city }}">
					    </div>
					</div>

					<div class="form-group">
						<label for="area" class="col-sm-3 control-label">Area</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="area" name="area" disabled value="{{ $area }}">
					    </div>
					</div>

					<div class="form-group">
						<label for="comments" class="col-sm-3 control-label">Comments</label>
					    <div class="col-sm-7">
					      <textarea class="form-control" id="comments" name="commentss" rows="5"></textarea>
					    </div>
					</div>

					<div class="form-group {{ $errors->has('delivery_type') ? 'has-error': '' }}">
						<label for="delivery_type" class="col-sm-3 control-label">Delivery Type</label>
					    <div class="col-sm-7">
					    	@if((bool) $restaurant->meta->deliveries)
					      	<div class="radio">
							  <label>
							    <input type="radio" name="delivery_type" id="delivery_type" value="delivery">
							    Delivery <br> Your meal will be delivered at your chosen address
							  </label>
							</div>
							@endif

							@if((bool) $restaurant->meta->pickups)
							<div class="radio">
							  <label>
							    <input type="radio" name="delivery_type" id="delivery_type" value="pickup">
							   Pickup <br> Pick up your meal at the restaurant
							  </label>
							</div>
							@endif

							 @if($errors->has('delivery_type'))
						      @foreach($errors->get('delivery_type') as $message)
						      <p class="help-block">{{ $message }}</p>
						      @endforeach
						      @endif
					    </div>
					</div>
				</div>

				<div class="cart-total clearfix">
					<div class="pull-left"><strong>Total</strong></div>
					<div class="pull-right"><b class="naira">N</b>{{ number_format($total,2) }}</div>
				</div>

				<div class="inner">
					<div class="form-group">
						<button type="submit" class="btn btn-success btn-lg btn-block">Place Order</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		@else
			<div class="account-tabs">
				<div class="navigation">
					<ul class="clearfix">
						<li class=""><a href="#account-signup" data-toggle="tab" >Create a Chawnow account</a></li>
						<li class="active"><a href="#account-login" data-toggle="tab">Existing Customer</a></li>
					</ul>
				</div>

				<div class="tab-content">
					<div class="tab-pane clearfix" id="account-signup">
						{{ Form::open(array('url'=>"signup", 'method'=>"post")) }}
						@if($errors->all())
						<div class="alert alert-danger">
							Please check that you have filled the form correctly
							<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
							</ul>
						</div>
						@endif 

						@if($message)
						<div class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							{{ $message }}
						</div>
						@endif

						<div class="inner">
							<div class="form-group col clearfix">
								<input type="hidden" name="redirect_url" value="{{ URL::to('checkout/'.$uid) }}">
								<input type="hidden" name="origin_url" value="{{ URL::to('checkout/'.$uid) }}">
								<input class="form-control {{ ($errors->has('first_name')) ? 'has-error' : ''}}" type="text" name="first_name" placeholder="First Name">
								<input class="form-control {{ ($errors->has('last_name')) ? 'has-error' : ''}}" type="text" name="last_name" placeholder="Last Name">
							</div>

							<div class="form-group col clearfix">
								<input class="form-control {{ ($errors->has('email')) ? 'has-error' : ''}}" type="text" name="email" placeholder="Email Address">
								<input class="form-control {{ ($errors->has('mobile_no')) ? 'has-error' : ''}}" type="text" name="mobile_no" placeholder="Mobile Number">
							</div>

							<div class="form-group col clearfix">
								<input class="form-control {{ ($errors->has('password')) ? 'has-error' : ''}}" type="password" name="password" placeholder="Password">
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-danger btn-lg btn-block">Sign Up</button>
							</div>
						</div>
						{{ Form::close() }}
					</div>

					<div class="tab-pane active" id="account-login">
						<div class="inner">
						{{ Form::open(array('url'=>"signin", 'method'=>"post")) }}
							
							@if($message)
							<div class="alert alert-info alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								{{ $message }}
							</div>
							@endif

							<div class="form-group">
								<input type="hidden" name="redirect_url" value="{{ URL::to('checkout/'.$uid) }}">
								<input type="hidden" name="origin_url" value="{{ URL::to('checkout/'.$uid) }}">
								<input class="form-control {{ ($errors->has('email')) ? 'has-error' : ''}}" type="text" name="email" placeholder="Email Address">
							</div>

							<div class="form-group">
								<input class="form-control {{ ($errors->has('password')) ? 'has-error' : ''}}" type="password" name="password" placeholder="Password">
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-danger btn-lg btn-block">Sign In</button>
							</div>
						{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
			<div class="customer-details">
				<h3>Customer Details</h3>
				{{ Form::open(array('url'=>'checkout/'.$uid, 'method'=> "post","class"=>"form-horizontal")) }}
				<div class="inner">
					<div class="form-group {{ $errors->has('first_name') ? 'has-error': '' }}">
						<label for="first_name" class="col-sm-3 control-label">First Name</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ Input::old('first_name') }}">
					      @if($errors->has('first_name'))
					      	<p class="help-block">{{ $errors->first('first_name') }}</p>
					      @endif
					    </div>
					</div>

					<div class="form-group {{ $errors->has('last_name') ? 'has-error': '' }}">
						<label for="last_name" class="col-sm-3 control-label">Last Name</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{ Input::old('last_name') }}">
					      @if($errors->has('last_name'))
					      	<p class="help-block">{{ $errors->first('last_name') }}</p>
					      @endif
					    </div>
					</div>

					<div class="form-group {{ $errors->has('mobile_no') ? 'has-error': '' }}">
						<label for="mobile_no" class="col-sm-3 control-label">Mobile Number</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile Number" value="{{ Input::old('mobile_no') }}">
					      @if($errors->has('mobile_no'))
					      @foreach($errors->get('mobile_no') as $message)
					      <p class="help-block">{{ $message }}</p>
					      @endforeach
					      @endif
					    </div>
					</div>

					<div class="form-group {{ $errors->has('email') ? 'has-error': '' }}">
						<label for="mobile_no" class="col-sm-3 control-label">Email</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="{{ Input::old('email') }}">
					      @if($errors->has('email'))
					      @foreach($errors->get('email') as $message)
					      <p class="help-block">{{ $message }}</p>
					      @endforeach
					      @endif
					    </div>
					</div>

					<div class="form-group {{ $errors->has('street') ? 'has-error': '' }}">
						<label for="street" class="col-sm-3 control-label">Street</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="street" name="street" placeholder="Street address" value="{{ Input::old('street') }}">
					       @if($errors->has('street'))
					      	<p class="help-block">{{ $errors->first('street') }}</p>
					      @endif
					    </div>
					</div>

					<div class="form-group">
						<label for="city" class="col-sm-3 control-label">City</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="city" name="city" disabled value="{{ $city }}">
					    </div>
					</div>

					<div class="form-group">
						<label for="area" class="col-sm-3 control-label">Area</label>
					    <div class="col-sm-7">
					      <input type="text" class="form-control" id="area" name="area" disabled value="{{ $area }}">
					    </div>
					</div>

					<div class="form-group">
						<label for="comments" class="col-sm-3 control-label">Comments</label>
					    <div class="col-sm-7">
					      <textarea class="form-control" id="comments" name="comments" rows="5">{{ Input::old('comments') }}</textarea>
					    </div>
					</div>

					<div class="form-group {{ $errors->has('delivery_type') ? 'has-error': '' }}">
						<label for="delivery_type" class="col-sm-3 control-label">Delivery Type</label>
					    <div class="col-sm-7">
					    	@if((bool) $restaurant->meta->deliveries)
					      	<div class="radio">
							  <label>
							    <input type="radio" name="delivery_type" id="delivery_type" value="delivery">
							    Delivery <br> Your meal will be delivered at your chosen address
							  </label>
							</div>
							@endif

							@if((bool) $restaurant->meta->pickups)
							<div class="radio">
							  <label>
							    <input type="radio" name="delivery_type" id="delivery_type" value="pickup">
							   Pickup <br> Pick up your meal at the restaurant
							  </label>
							</div>
							@endif

							 @if($errors->has('delivery_type'))
						      @foreach($errors->get('delivery_type') as $message)
						      <p class="help-block">{{ $message }}</p>
						      @endforeach
						      @endif
					    </div>
					</div>
				</div>

				<div class="cart-total clearfix">
					<div class="pull-left"><strong>Total</strong></div>
					<div class="pull-right grand-total"><b class="naira">N</b>{{ number_format($total,2) }}</div>
				</div>

				<div class="inner">
					<div class="form-group">
						<button type="submit" class="btn btn-success btn-lg btn-block">Place Order</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		@endif
		</div>

		<div class="col-md-3 user-cart">
			<div class="cart-header clearfix">
				<div class="pull-left">Your Order</div>
				<div class="pull-right"><a href="{{ URL::to('restaurant/'.$restaurant->slug) }}" class="btn btn-default btn-sm">Change Order</a></div>
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
				@endif
			</div>
			<div class="cart-footer">
				@if((bool) $restaurant->meta->deliveries)
				<p><i class="icon-time"></i> Delivery in: {{ $restaurant->meta->delivery_time }}</p>
				@endif
				@if((bool) $restaurant->meta->pickups)
				<p><i class="icon-time"></i> Pickup in: {{ $restaurant->meta->pickup_time }}</p>
				@endif
			</div>
		</div>
	</div>
</div>
@stop
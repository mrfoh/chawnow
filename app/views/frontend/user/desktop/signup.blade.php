@section('title')
Chawnow | Online Food Ordering | Sign Up
@stop

@section('page_class') signup-page @stop

@section('scripts')
<script type="text/javascript">
$(function() {
	//initialize tooltips
	$('[rel="tooltip"]').tooltip();
});
</script>
@stop

@section('description')
Order from the best local restaurants • Select your food from a large choice : pizza, sushi, American food... •  Fast and convenient •  Cash on delivery.
@stop

@section('content')
<div class="page-content container">

	<div class="row">
		<div class="col-md-12 signup-box">
			<div class="inner clearfix">
				<div class="pull-left signup-form-box">
					{{ Form::open( array("url" => "signup", "method" => "post") ) }}
						<h3>Create a Chawnow Account</h3>

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

						<div class="form-group clearfix col2">
							<input class="form-control {{ ($errors->has('first_name')) ? 'has-error' : ''}}" type="text" name="first_name" id="first-name" placeholder="First Name*" value="{{ Input::old('first_name')}}">
							<input class="form-control {{ ($errors->has('last_name')) ? 'has-error' : ''}}" type="text" name="last_name" id="last-name" placeholder="Last Name*" value="{{ Input::old('last_name')}}">
						</div>

						<div class="form-group clearfix col2">
							<input class="form-control {{ ($errors->has('email')) ? 'has-error' : ''}}" type="text" name="email" id="email" placeholder="Email address*" value="{{ Input::old('email')}}">
							<input class="form-control {{ ($errors->has('mobile_no')) ? 'has-error' : ''}}" type="text" name="mobile_no" id="mobile-no" placeholder="Mobile number*" value="{{ Input::old('mobile_no')}}" rel="tooltip" title="Your mobile no will be used to verify your orders. Unverified orders cannot be completed">
						</div>

						<div class="form-group">
							<input class="form-control {{ ($errors->has('password')) ? 'has-error' : ''}}" type="password" name="password" id="password" placeholder="Password*">
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-danger btn-block btn-lg">Sign Up</button>
							<span class="help-block">By clicking this button, you accept our <a href="/tos">terms of service</a></span>
						</div>

						<!--<div class="form-group">
							<a href="/signup/facebook" class="btn btn-info">
								<i class="icon icon-facebook icon-large"></i> Sign up with facebook
							</a>
						</div>-->						
					{{ Form::close() }}
				</div>

				<div class="pull-right features">
					<h3>A Chawnow account gives you great features</h3>
					<ul class="feature-list">
						<li>
							<h4><span style="color: green;" class="icon icon-refresh icon-large"></span> Easy Reordering</h4>
							<p></span>Your past orders are remembered for easy reordering</p>
						</li>
						<li>
							<h4><span style="color: red;" class="icon icon-heart icon-large"></span> Save your favourites</h4>
							<p>Save your favourites restaurants for easier access</p>
						</li>
						<li>
							<h4><span class="icon icon-home icon-large"></span> Save your addresses</h4>
							<p>Your addresses - home, work, wherever -are saved to save your time when ordering</p>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

</div>
@stop
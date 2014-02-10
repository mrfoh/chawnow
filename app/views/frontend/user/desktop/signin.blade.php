@section('title')
Chawnow | Online Food Ordering | Sign In
@stop

@section('page_class') signin-page @stop

@section('description')
Order from the best local restaurants • Select your food from a large choice : pizza, sushi, American food... •  Fast and convenient •  Cash on delivery.
@stop

@section('content')
<div class="page-content container">

	<div class="row">
		<div class="col-md-12">
			<div class="signin-box">
				<h3>Signin To Your Chawnow Account</h3>
				{{ Form::open(array('url'=>"signin", 'method'=>"post")) }}
					@if($message)
					<div class="alert alert-info">{{ $message }}</div>
					@endif
					<div class="form-group">
						<label for="email">Email</label>
						<input class="form-control" type="email" id="email" name="email">
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input class="form-control" type="password" id="password" name="password">
					</div>

					<div class="form-group">
						<input type="submit" value="Sign In" class="btn btn-warning btn-block btn-lg">
					</div>

					<div class="form-group">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="remember" value="true">
								Remember Me
							</label>
						</div>
						<a href="/forgot-password">Forgot your password?</a>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>

</div>
@stop
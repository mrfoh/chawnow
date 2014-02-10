@section('title')
Sign in | Chawnow | Online Food Ordering
@stop

@section('content')
<div class="page" id="signin-page">

	<div class="content-box form-box ui-shadow">
		<h3>Sign In</h3>
		@if($message)
			<div class="alert alert-info">
				{{ $message }}
			</div>
		@endif

		@if($errors->all())
			<div class="alert alert-danger">
				Please enter your email address and password.
			</div>
		@endif

		{{ Form::open(array('url'=>"signin", 'method'=>"post", 'data-ajax'=>"false")) }}
			<input type="text" name="email" id="email" placeholder="Email Address">
			<input type="password" name="password" id="password" placeholder="Password">
			<button type="submit" class="ui-btn btn-warning">Sign In</button>

			<a href="/signup">I dont have an account</a>
		{{ Form::close() }}
	</div>
</div>
@stop
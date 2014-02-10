@section('title')
Sign up | Chawnow | Online Food Ordering
@stop

@section('content')
<div class="page" id="signin-page">

	<div class="content-box form-box ui-shadow">
		<h3>Create an account</h3>
		@if($errors->all())
		<div class="alert alert-danger">Your form has some errors.</div>
		@endif

		@if($message)
		<div class="alert alert-info">{{ $message }}</div>
		@endif
		{{ Form::open(array('url'=>"signup", 'method'=>"post", 'data-ajax'=>"false")) }}
			<input type="text" class="{{ ($errors->has('first_name')) ? 'has-error' : '' }}" name="first_name" id="first_name" placeholder="First Name" value="{{ Input::old('first_name') }}">
			@if($errors->has('first_name'))
			@foreach($errors->get('first_name') as $message) <span class="field-error">{{ $message }}</span>@endforeach
			@endif

			<input type="text" class="{{ ($errors->has('last_name')) ? 'has-error' : '' }}"name="last_name" id="last_name" placeholder="Last Name" value="{{ Input::old('last_name') }}">
			@if($errors->has('last_name'))
			@foreach($errors->get('first_name') as $message) <span class="field-error">{{ $message }}</span>@endforeach
			@endif

			<input type="tel" class="{{ ($errors->has('mobile_no')) ? 'has-error' : '' }}"name="mobile_no" id="mobile_no" placeholder="Mobile Phone No" value="{{ Input::old('mobile_no') }}">
			@if($errors->has('mobile_no'))
			@foreach($errors->get('mobile_no') as $message) <span class="field-error">{{ $message }}</span>@endforeach
			@endif

			<input type="email" class="{{ ($errors->has('email')) ? 'has-error' : '' }}"name="email" id="email" placeholder="Email Address" value="{{ Input::old('email') }}">
			@if($errors->has('email'))
			@foreach($errors->get('email') as $message) <span class="field-error">{{ $message }}</span>@endforeach
			@endif

			<input type="password" class="{{ ($errors->has('password')) ? 'has-error' : '' }}" name="password" id="password" placeholder="Password">
			@if($errors->has('password'))
			@foreach($errors->get('password') as $message) <span class="field-error">{{ $message }}</span>@endforeach
			@endif

			<button type="submit" class="ui-btn btn-warning">Sign Up</button>

			<a href="/signin">I have an account</a>
		{{ Form::close() }}
	</div>
</div>
@stop
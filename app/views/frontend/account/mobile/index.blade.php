@section('title')
My Account | Chawnow | Online Food Ordering
@stop

@section('content')
<div class="page" id="account-page">

	<div class="content-box ui-shadow">
		<h3>My Account</h3>

		@if($message)
		<div class="alert alert-info">{{ $message}}</div>
		@endif

		{{ Form::open(array('url'=>"account/update", 'method'=>"post", 'data-ajax'=>"false" )) }}
		<label for="first_name" style="margin-top: 1em;">First Name</label>
		<input type="text" class="{{ $errors->has('first_name') ? 'has-error': '' }}" name="first_name" id="first_name" placeholder="First Name" value="{{ $user->first_name }}">

		<label for="last_name">Last Name</label>
		<input type="text" class="{{ $errors->has('last_name') ? 'has-error': '' }}" name="last_name" id="last_name" placeholder="Last Name" value="{{ $user->last_name }}">

		<label for="first_name">Email Address</label>
		<input type="text" class="{{ $errors->has('email') ? 'has-error': '' }}" name="email" id="email" placeholder="Email Address" value="{{ $user->email }}">

		<label for="first_name">Mobile No</label>
		<input type="text" class="{{ $errors->has('mobile_no') ? 'has-error': '' }}" name="mobile_no" id="mobile_no" placeholder="Mobile No" value="{{ $profile->mobile_no }}">

		<button type="submit" class="ui-btn btn-warning">Save</button>
		{{ Form::close() }}
	</div>
</div>
@stop
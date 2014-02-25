@section('title')
{{ $restaurantData->name }} | Change Password
@stop

@section('content')
<div class="row-fluid" id="ua-app">

	<div class="span6 offset3">
		<div class="grid simple">
			<div class="grid-title">
				<h4>Change your password</h4>
			</div>

			<div class="grid-body">
				{{ Form::open(array('url'=>'user/change-password', 'method'=>'post')) }}
				@if($message)
				<div class="alert alert-info">{{ $message }}</div>
				@endif
				<div class="control-group">
					<label class="control-label">Old Password</label>
					<div class="controls {{ ($errors->has('old_password')) ? 'error-control' : ''}}">
						<input type="password" class="span12" name="old_password" id="old_password" placeholder="Enter your old password">
						@if($errors->has('old_password'))
						@foreach($errors->get('old_password') as $message) <span class="error">{{ $message }}</span>@endforeach
						@endif
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">New Password</label>
					<div class="controls {{ ($errors->has('new_password')) ? 'error-control' : ''}}">
						<input type="password" class="span12" name="new_password" id="new_password" placeholder="Enter your new password">
						@if($errors->has('new_password'))
						@foreach($errors->get('new_password') as $message) <span class="error">{{ $message }}</span>@endforeach
						@endif
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Confirm Password</label>
					<div class="controls {{ ($errors->has('confpassword')) ? 'error-control' : ''}}">
						<input type="password" class="span12" name="confpassword" id="confpassword" placeholder="Re-enter your new password">
						@if($errors->has('confpassword'))
						@foreach($errors->get('confpassword') as $message) <span class="error">{{ $message }}</span>@endforeach
						@endif
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" class="btn btn-cons btn-danger">Save</button>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>

</div>
@stop
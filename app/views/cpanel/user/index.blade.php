@section('title')
{{ $restaurantData->name }} | User Account
@stop

@section('content')
<div class="row-fluid" id="ua-app">

	<div class="span6 offset3">
		<div class="grid simple">
			<div class="grid-title">
				<h4>Your Account</h4>
			</div>

			<div class="grid-body">
				{{ Form::open(array('url'=>'user/update', 'method'=>'post')) }}
				@if($message)
				<div class="alert alert-info">{{ $message }}</div>
				@endif
				<div class="control-group">
					<label class="control-label">First Name</label>
					<div class="controls">
						<input type="text" class="span12" name="first_name" id="first_name" value="{{ $user->first_name }}">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Last Name</label>
					<div class="controls">
						<input type="text" class="span12" name="last_name" id="last_name" value="{{ $user->last_name }}">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Email Address</label>
					<div class="controls">
						<input type="text" class="span12" name="email" id="email" value="{{ $user->email }}">
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
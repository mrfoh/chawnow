@section('title')
Admin | Users | {{ ($action == "new") ? "New User" : "Edit User"}}
@stop

@section('scripts')
{{ HTML::script('assets/js/plugins/jquery.validate.min.js') }}
{{ HTML::script('assets/js/backend/views/users/form.js') }}
<script type="text/javascript">
$(document).ready(function (){
	var View = new Backend.Views.UserFormView();
});
</script>
@stop

@section('content')
<div class="page-title">
	<h4>Users</h4>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="grid simple">
			<div class="grid-title">
				<h4>{{ ($action == "new") ? "New User" : "Edit User"}}</h4>
			</div>

			<div class="grid-body">
			@if($action == "new")
			{{ Form::open(array('url'=>"users/add", 'method'=>"post", 'class'=>"form-no-horizontal-spacing", "id"=>"user-form")) }}
			@else
			{{ Form::open(array('url'=>"users/".$id."/edit", 'method'=>"post", 'class'=>"form-no-horizontal-spacing", "id"=>"user-form")) }}
			@endif

			@if($flashMessage)
			<div class="alert alert-error">
				<button class="close" data-dismiss="alert"></button>
				{{ $flashMessage }}
			</div>
			@endif

			@if($errors->all())
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert"></button>
				@foreach($errors->all() as $errorMsg)
				<p>{{ $errorMsg }}
				@endforeach
			</div>
			@endif
			<div class="row-fluid column-seperation">
				<div class="span6">
					<h4>Basic Information</h4>
					<div class="row-fluid">
						<div class="span6">
							@if(!$user)
							<input type="text" name="firstname" id="firstname" class="span12" placeholder="First Name" value="{{ Input::old('firstname') }}">
							@else
							<input type="text" name="firstname" id="firstname" class="span12" placeholder="First Name" value="{{ $user->first_name }}">
							@endif
						</div>
						<div class="span5">
							@if(!$user)
							<input type="text" name="lastname" id="lastname" class="span12" placeholder="Last Name" value="{{ Input::old('lastname') }}">
							@else
							<input type="text" name="lastname" id="lastname" class="span12" placeholder="Last Name" value="{{ $user->last_name }}">
							@endif
						</div>
					</div>
					<div class="row-fluid">
						<div class="span11">
							@if(!$user)
							<input type="text" name="email" id="email" class="span12" placeholder="Email Address" value="{{ Input::old('email') }}">
							@else
							<input type="text" name="email" id="email" class="span12" placeholder="Email Address" value="{{ $user->email }}">
							@endif
						</div>
					</div>
					<div class="row-fluid">
						<div class="span11">
							@if(!$user)
							<input type="password" name="password" id="password" class="span12" placeholder="Password">
							@else
							<input type="password" name="password" id="password" class="disabled span12" placeholder="Password" value="snhksnkhskh" disabled>
							@endif
						</div>
					</div>
					<div class="row-fluid">
						<div class="span11">
							@if(!$user)
							<input type="password" name="confpassword" id="confpassword" class="span12" placeholder="Confirm Password">
							@else
							<input type="password" name="confpassword" id="confpassword" class="disabled span12" placeholder="Confirm Password" value="snhksnkhskh" disabled>
							@endif
						</div>
					</div>
				</div>

				<div class="span6">
					<h4>Profile Information</h4>
					<div class="row-fluid">
						<div class="span11">
							@if(!$user)
							{{ Form::select('group', $groups, Input::old('group'), array("class"=>"span10", "id"=>"group")) }}
							@else
							{{ Form::select('group', $groups, $group[0]->id, array("class"=>"span10", "id"=>"group")) }}
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="form-actions">
				<div class="pull-right">
					<button class="btn btn-danger btn-cons" type="submit"><i class="icon-ok"></i> Save</button>
					<a class="btn btn-white btn-cons" href="/users">Cancel</a>
				</div>
			</div>
			{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@stop
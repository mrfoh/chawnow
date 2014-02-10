@section('title')
My Account | Chawnow | Online Food Ordering
@stop

@section('page_class') account-page @stop

@section('content')
<div class="page-content container">
	<div class="row">
		<div class="col-md-4 account-page-sidebar">
			<div class="card">
				<ul>
					<li class="active"><a href="/account">My Account</a></li>
					<li><a href="/account/orders">My Orders</a></li>
					<li><a href="/account/addresses">My Addresses</a></li>
					<li><a href="/account/password">Change Password</a></li>
				</ul>
			</div>
		</div>

		<div class="col-md-8 account-page-content">
			<div class="card">
				<div class="card-header">My Account</div>
				<div class="card-content">
				{{ Form::open(array('url'=>'account/update', 'method'=>'post', 'id'=>'account-form')) }}
					@if($message)
					<div class="alert alert-info">{{ $message}}</div>
					@endif
					<div class="form-group ">
						<label for="first_name">First Name</label>
						<input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}">
					</div>

					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}">
					</div>

					<div class="form-group">
						<label for="">Email</label>
						<input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
					</div>

					<div class="form-group">
						<label for="mobile_no">Mobile Number</label>
						<input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{ $profile->mobile_no }}">
					</div>

					<div class="form-group">
						<input type="submit" class="btn btn-warning btn-lg btn-block" value="Save">
					</div>
				{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
@stop
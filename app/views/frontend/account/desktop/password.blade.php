@section('title')
Change Password | Chawnow | Online Food Ordering
@stop

@section('page_class') account-page @stop

@section('description')
Order from the best local restaurants • Select your food from a large choice : pizza, sushi, American food... •  Fast and convenient •  Cash on delivery.
@stop

@section('content')
<div class="page-content container">
	<div class="row">
		<div class="col-md-4 account-page-sidebar">
			<div class="card">
				<ul>
					<li><a href="/account">My Account</a></li>
					<li><a href="/account/orders">My Orders</a></li>
					<li><a href="/account/addresses">My Addresses</a></li>
					<li class="active"><a href="/account/password">Change Password</a></li>
				</ul>
			</div>
		</div>

		<div class="col-md-8 account-page-content">
			<div class="card">
				<div class="card-header">Change Password</div>
				<div class="card-content">
				{{ Form::open(array('url'=>'account/password', 'method'=>'post', 'id'=>'account-form')) }}
					@if($message)
					<div class="alert alert-info">{{ $message}}</div>
					@endif

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

					<div class="form-group {{ ($errors->has('old')) ? 'has-error' : ''}}">
						<label for="old">Old Password</label>
						<input type="password" class="form-control" id="old" name="old" value="">
					</div>

					<div class="form-group {{ ($errors->has('newpassword')) ? 'has-error' : ''}}">
						<label for="new">New Password</label>
						<input type="password" class="form-control" id="new" name="newpassword" value="">
					</div>

					<div class="form-group {{ ($errors->has('confnewpassword')) ? 'has-error' : ''}}">
						<label for="confnew">Confirm Password</label>
						<input type="password" class="form-control" id="confnew" name="confnewpassword" value="">
					</div>
			
					<div class="form-group">
						<input type="submit" class="btn btn-warning btn-lg btn-block" value="Change Password">
					</div>
				{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
@stop
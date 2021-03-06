@extends('cpanel.layouts.login')

@section('title') Login @stop

@section('content')
<div class="login-page">

	<div class="container">
		<div class="logo"></div>
		
		<div class="login-box">
			<h3>Restuarant Control Panel</h3>
			@if($flashMessage)
			<div class="alert alert-info">{{ $flashMessage }}</div>
			@endif
			{{ Form::open(array("url"=>"login", "method"=>"post", "id"=>"login-form")) }}
				<input class="form-control email" type="text" name="email" placeholder="Email">
				<input class="form-control password" type="password" name="password" placeholder="Password">
				<button class="btn btn-lg btn-block btn-info" style="margin-top:10px;">Sign In</button>

				<div class="form-group">
					<label class="checkbox-inline">
						<input type="checkbox" name="remember" value="true"> Stay signed in
					</label>
				</div>
			{{ Form::close() }}
		</div>
	</div>

</div>
@stop
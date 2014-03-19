<!doctype html>
<html lang="en-gb">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>@yield('title')</title>

		<!-- Le Stylesheets -->
		{{ HTML::style('assets/css/controlpanel/theme/plugins/bootstrap/css/bootstrap.min.css') }}
		{{ HTML::style('assets/css/controlpanel/theme/plugins/bootstrap/css/bootstrap-responsive.min.css') }}
		{{ HTML::style('assets/css/font-awesome.css') }}
		{{ HTML::style('assets/css/controlpanel/theme/theme.css') }}
	</head>

	<body>
		<div class="viewport" id="app">
		@include('cpanel.partials.header')

		<div class="page-container row-fluid"><!-- .page-container -->
			<div class="page-sidebar" id="main-menu"><!-- .page-sidebar -->
				<div class="user-info-wrapper">	
				    <div class="profile-wrapper">
						<img src="{{ $restaurantData->logo }}" style="width:69px; height:62px;"width="69" height="69" />
					</div>
					<div class="user-info">
					    <div class="greeting">Welcome</div>
					    <div class="username">{{ $restaurantData->name }}</div>
					    @if($status)
					    <div class="status">Status<a href="#"><div class="status-icon green"></div>Open</a></div>
					    @else
					    <div class="status">Status<a href="#"><div class="status-icon red"></div>Closed</a></div>
					    @endif
					</div>
				</div>
				<ul>
					<li><a href="/"><i class="icon-custom-home"></i> <span class="title">Dashboard</span> <span class="selected"></span></a></li>
					<li><a href="/menus"><i class="icon-paste"></i> <span class="title">Menus</span></a></li>
			      	<li><a href="/orders"><i class="icon-shopping-cart"></i> <span class="title">Orders</span></a></li>
			      	<li><a href="/hours"><i class="icon-time"></i> <span class="title">Hours</span></a></li>
			      	<li><a href="/account"><i class="icon-cogs"></i> <span class="title">Account Settings</span></a></li>
			      	<li><a href="/staff"><i class="icon-group"></i> <span class="title">Staff</span></a></li>
			      	<li><a href="javascript:;"><i class="icon-custom-chart"></i> <span class="title">Reports &amp; Analytics</span> <span class="arrow"></span></a>
			      		<ul class="sub-menu">
			      			<li><a href="/analytics/orders">Orders</a></li>
			      		</ul>
			      	</li>
				</ul>

				<a href="#" class="scrollup">Scroll</a>
				<div class="clearfix"></div>
			</div><!-- end .page-sidebar -->

			<div class="footer-widget">
				<div class="pull-right">
					<a href="/logout"><i class="icon-off"></i></a>
				</div>
			</div>

			<div class="page-content">
				<div class="clearfix"></div>
				<div class="content">
				@yield('content')
				</div>
			</div>
		</div><!-- end .page-container -->
	</div>

	
	<script type="text/javascript">
		window.Cpanel = window.Cpanel || {};
		Cpanel.Views = Cpanel.Views || {};
		Cpanel.Constants = {
			url : "http://{{ Config::get('app.cpanel_url') }}"
		}
	</script>

	<!-- Core Scripts -->
	{{ HTML::script('assets/js/libs/jquery.js') }}
	{{ HTML::script('assets/js/libs/jquery.ui.js') }}
	{{ HTML::script('assets/js/plugins/backend.min.js') }}
	{{ HTML::script('assets/js/libs/backbone/underscore-min.js') }}
	{{ HTML::script('assets/js/libs/backbone/backbone-min.js')  }}

	<!-- Core Code Snippets -->
	<script type="text/javascript">
	$(document).ready(function() {
		$('.page-sidebar ul li a').each(function() {
			if($(this).attr('href') == window.location.pathname)
				$(this).parent('li').addClass('active');
		});
	});
	</script>
	<!-- Page Scripts -->
	@yield('scripts')
	</body>
</html>
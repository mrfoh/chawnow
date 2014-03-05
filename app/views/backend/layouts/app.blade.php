<!doctype html>
<html lang="en-gb">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>@yield('title')</title>

		<!-- Le Stylesheets -->
		{{ HTML::style('assets/css/backend/theme/plugins/bootstrap/css/bootstrap.min.css') }}
		{{ HTML::style('assets/css/backend/theme/plugins/bootstrap/css/bootstrap-responsive.min.css') }}
		{{ HTML::style('assets/css/font-awesome.css') }}
		{{ HTML::style('assets/css/backend/theme/theme.css') }}
	</head>

	<body>
	<div class="viewport" id="app">
		@include('backend.partials.header')

		<div class="page-container row-fluid"><!-- .page-container -->
			<div class="page-sidebar" id="main-menu"><!-- .page-sidebar -->
				<p class="menu-title">Menu <span class="pull-right"><a href="javascript:;"><i class="icon-refresh"></i></a></span></p>
				<ul>
					<li><a href="/"><i class="icon-custom-home"></i> <span class="title">Dashboard</span> <span class="selected"></span></a></li>
					<li> <a href="javascript:;"> <i class="icon-group"></i> <span class="title">Users</span> <span class="arrow"></span> </a>
				        <ul class="sub-menu">
				        	<li><a href="/users/add">New User</a></li>
						    <li><a href="/users">Users</a></li>
				        </ul>
			      	</li>
			      	<li><a href="javascript:;"><i class="icon-food"></i> <span class="title">Restaurants</span> <span class="arrow"></span></a>
			      		<ul class="sub-menu">
			      			<li><a href="/restaurants/add">Add Restaurant</a></li>
			      			<li><a href="/restaurants">Restaurants</a></li>
			      			<li><a href="/cuisines">Cuisines</a></li>
			      		</ul>
			      	</li>
			      	<li><a href="/orders"><i class="icon-shopping-cart"></i> <span class="title">Orders</span></a></li>
			      	<li><a href="/locations"><i class="icon-map-marker"></i> <span class="title">Locations</span></a></li>
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

	<!-- Core Scripts -->
	<script type="text/javascript">
		window.Backend = window.Backend || {};
		Backend.Constants = {
			url : "http://{{ Config::get('app.backend_url') }}"
		}
		Backend.Views = Backend.Views || {};
	</script>
	{{ HTML::script('assets/js/libs/jquery.js') }}
	{{ HTML::script('assets/js/plugins/backend.min.js') }}
	{{ HTML::script('assets/js/libs/backbone/underscore-min.js') }}
	{{ HTML::script('assets/js/libs/backbone/backbone-min.js') }}
	{{ HTML::script('assets/js/backend/backend.min.js') }}
	@yield('scripts')
	</body>
</html>
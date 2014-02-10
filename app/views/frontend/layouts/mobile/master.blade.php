<!doctype html>
<html lang="en-gb">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="Chawnow, ChawNow, delivery, order, food, nigeria, 'port-harcourt' ng, online", "PHC">
		<meta name="description" content="Order from the best local restaurants in Port-Harcourt, Nigeria• Select your food from a large choice : pizza, sushi, American food... •  Fast and convenient •  Cash on delivery.
">
		<meta property="og:url" content="http://www.chawnow.com/" />
		<meta property="og:type" content="website" />
		<meta property="og:site_name" content="Chawnow"/>
		<title>@yield('title')</title>

		<!-- Load jQuery mobile stylesheet -->
		{{ HTML::style('assets/css/jquery.mobile-1.4.0.min.css') }}
		{{ HTML::style('assets/css/frontend/mobile/mobile-theme.css') }}
	</head>

	<body id="viewport">
		<div data-role="page" id="wrapper">
			<div data-role="panel" data-display="push" id="menu-panel">
			   <ul data-role="listview">
			   	   <li><a href="/" data-ajax="false">Home</a></li>
			   	   @if(!$isLoggedin)
				   <li><a href="/signin" data-ajax="false">Sign In</a></li>
				   <li><a href="/signup" data-ajax="false">Sign Up</a></li>
				   @else
				   <li><a href="/account" data-ajax="false">My Account</a></li>
				   <li><a href="/account/orders" data-ajax="false">My Orders</a></li>
				   <li><a href="/logout" data-ajax="false">Logout</a></li>
				   @endif
				   <li><a href="/contact" data-ajax="false">Contact Us</a></li>
				   <li><a href="/faqs" data-ajax="false">Faqs</a></li>
			   </ul>
			</div><!-- /panel -->

			<div data-role="header">
				<a href="#menu-panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-nodisc-icon ui-corner-all panel-trigger"></a>
				<div class="logo"></div>
			</div><!-- /header -->

			<div data-role="main" class="ui-content">@yield('content')</div>
		</div>

		<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="{{ URL::to("assets/js/libs/jquery.js") }}">\x3C/script>')</script>
		<!-- Load jQuery mobile -->
		{{ HTML::script('assets/js/libs/jquery.mobile-1.4.0.min.js') }}
		<!-- Load Backbone -->
		{{ HTML::script('assets/js/libs/backbone/underscore-min.js') }}
		{{ HTML::script('assets/js/libs/backbone/backbone-min.js') }}

		<script type="text/javascript">
			//namespace
			window.Chawnow = window.Chawnow || {};
				   Chawnow.Views = Chawnow.Views || {};
				   Chawnow.Constants = { url: "{{ Config::get('app.url') }}" };

			//initialization code
			$(document).bind('mobileinit', function() {

				$.mobile.ajaxEnabled = false;
		        $.mobile.linkBindingEnabled = false;
		        $.mobile.hashListeningEnabled = false;
		        $.mobile.pushStateEnabled = false;
			});	
		</script>
		@yield('scripts')
	</body>
</html>
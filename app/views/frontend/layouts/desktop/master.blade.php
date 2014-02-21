<!doctype html>
<html lang="en-gb">
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="@yield('description')">
		<meta name="keywords" content="Chawnow, ChawNow, delivery, order, food, nigeria, 'port-harcourt' ng, online", 'PHC'>
		<meta name="description" content="Order from the best local restaurants in Port-Harcourt, Nigeria • Select your food from a large choice : pizza, sushi, American food... •  Fast and convenient •  Cash on delivery.
"> 
		<meta name="viewport" content="width=device-width,initial-scale=1" />
		<meta property="og:url" content="http://www.chawnow.com/" />
		<meta property="og:type" content="website" />
		<meta property="og:site_name" content="Chawnow"/>
		<title>@yield('title')</title>

		<!-- Le Stylesheets -->
		{{ HTML::style('assets/css/bootstrap.min.css') }}
		{{ HTML::style('assets/css/font-awesome.css') }}
		{{ HTML::style('assets/css/frontend/theme.css') }}

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	    <![endif]-->
	</head>

	<body>
		<div class="viewport @yield('page_class')">
			<header class="site-header">
				<div class="header-inner container clearfix">
					<div class="logo pull-left"><a href="{{ Config::get('app.url') }}"></a></div>

					<ul class="site-nav pull-right">
						<li class="top-link"><a href="/" class="link">Home</a></li>
						<li class="top-link"><a href="/how-it-works" class="link">How it works</a></li>
						<li class="top-link"><a href="#" class="link">Help</a></li>
						@if(!$isLoggedin)
						<li class="top-link"><a href="/signin" class="link">Sign In</a></li>
						<li class="top-link"><a href="/signup" class="link">Sign Up</a></li>
						@else
						<li class="top-link"><a href="/account" class="link">My Account</a></li>
						<li class="top-link"><a href="/logout" class="link">Logout</a></li>
						@endif
					</ul>
				</div>
			</header>

			<section class="site-content">@yield('content')</section>

			<footer class="site-footer">
				<div class="footer-inner container clearfix">
					<div class="newsletter-box pull-left">
						<h3>Subscribe to our newsletter</h3>
						<div class="form-group">
							<input type="text" class="form-control" name="email" placeholder="Enter your e-mail">
						</div>
						<div class="form-group">
							<button class="btn btn-lg btn-danger">Subscribe</button>
						</div>
						<p>Recieve deals from restaurants <br> Recieve great offers from Chawnow</p>
					</div>

					<div class="cuisine-box pull-left">
						<h3>Cuisines</h3>
						<ul class="list clearfix">
						@foreach($cuisines as $cuisine)
						<li><a href="/search?cuisine={{ $cuisine->id }}">{{ $cuisine->name }}</a></li>
						@endforeach
						</ul>
					</div>

					<div class="company-box pull-left">
						<h3>Chawnow</h3>
						<ul class="list">
							<li><a href="#">About</a></li>
							<li><a href="#">Contact Us</a></li>
							<li><a href="#">Terms</a></li>
							<li><a href="#">Privacy Policy</a></li>
						</ul>
					</div>

					<div class="social-box pull-left">
						<h3>Connect with us</h3>
						<ul>
							<li><a href="http://facebook.com/chawnowofficial" target="_blank"><i class="icon icon-facebook icon-large"></i></a></li>
							<li><a href="#"><i class="icon icon-twitter icon-large"></i></a></li>
							<li><a href="#"><i class="icon icon-instagram icon-large"></i></a></li>
							<li><a href="#"><i class="icon icon-tumblr icon-large"></i></a></li>
						</ul>
					</div>
				</div>

				<div class="footer-inner container">
					<p class="copyright">{{ date("Y", time()) }} &copy; ChawNow. All Rights Reserved</p>
				</div>
			</footer>
		</div>

		<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="{{ URL::to("assets/js/libs/jquery.js") }}">\x3C/script>')</script>
		{{ HTML::script('assets/js/bootstrap.min.js') }}
		{{ HTML::script('assets/js/libs/backbone/underscore-min.js') }}
		{{ HTML::script('assets/js/libs/backbone/backbone-min.js') }}
		<script type="text/javascript">
			window.Chawnow = window.Chawnow || {};
				   Chawnow.Views = Chawnow.Views || {};
				   Chawnow.Constants = { url: "{{ Config::get('app.url') }}" };

			$(document).ready(function() {
				//set active links
				$('.site-nav li a').each(function() {
					var pathname = window.location.pathname;
					if($(this).attr('href') == pathname)
						$(this).parent('li').addClass('active');
				});
			});
		</script>
		@yield('scripts')
	</body>
</html>
<!doctype html>
<html lang="en-gb">
	<head>
		<meta charset="UTF-8">
		<title>Chawnow | Control Panel | @yield('title') </title>

		{{ HTML::style('assets/css/bootstrap.min.css') }}
		{{ HTML::style('assets/css/controlpanel/theme.css') }}
	</head>

	<body>
		<div class="viewport">
		@yield('content')
		</div>
	</body>
</html>
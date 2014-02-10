@section('title')
Chawnow | Online Food Ordering |  How it works
@stop

@section('page_class') howitworks-page @stop

@section('description')
Order from the best local restaurants • Select your food from a large choice : pizza, sushi, American food... •  Fast and convenient •  Cash on delivery.
@stop

@section('content')
<div class="page-content container">
	<div class="row">

		<div class="col-md-12">
			<div class="head-line">
				<h2>How it works</h2>
				<p>Ordering food online with chawnow is super easy, just follow the steps below</p>
			</div>
		</div>

	</div>

	<div class="row steps">

		<div class="col-md-3 step">
			<div class="inner">
				<div class="pictogram">{{ HTML::image('assets/img/howitworks/icon-marker.png') }}</div>
				<div class="content">
					<h3 class="step-no"><a href="">1</a> Enter your location</h3>
					<p>Select your city and area to find restaurants in your vicinity</p>
				</div>
			</div>
		</div>

		<div class="col-md-3 step">
			<div class="inner">
				<div class="pictogram">{{ HTML::image('assets/img/howitworks/icon-order.png') }}</div>
				<div class="content">
					<h3 class="step-no"><a href="">2</a> Select a restaurant</h3>
					<p>Select a restaurant and order your meal for pickup or delivery</p>
				</div>
			</div>
		</div>

		<div class="col-md-3 step">
			<div class="inner">
				<div class="pictogram">{{ HTML::image('assets/img/howitworks/icon-delivery.png') }}</div>
				<div class="content">
					<h3 class="step-no"><a href="">3</a> Restaurant delivers</h3>
					<p>The restaurant delivers your food to you</p>
				</div>
			</div>
		</div>

		<div class="col-md-3 step">
			<div class="inner">
				<div class="pictogram">{{ HTML::image('assets/img/howitworks/icon-wallet.png') }}</div>
				<div class="content">
					<h3 class="step-no"><a href="">4</a> Pay</h3>
					<p>Pay cash on delivery of your food</p>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 call-to-action clearfix">
			<div class="pull-left"><h3>Own a restaurant and want to start take orders online?</h3></div>
			<div class="pull-right"><a href="/contact" class="btn btn-danger">Get in touch</a></div>
		</div>
	</div>
</div>
@stop
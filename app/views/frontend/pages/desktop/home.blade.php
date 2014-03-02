@section('title')
Chawnow | Online Food Ordering
@stop

@section('page_class') home-page @stop

@section('scripts')
{{ HTML::script('assets/js/plugins/typeahead.min.js') }}
{{ HTML::script('assets/js/frontend/views/home/index.js') }}
<!--<script type="text/javascript" src="{{ cdn( '/assets/js/master.min.js' ) }}"></script>-->
<script type="text/javascript">
Chawnow.data = { cities: {{ json_encode($cities) }}, areas: {{ json_encode($areas) }} };
$(document).ready(function() {
	var view = new Chawnow.Views.Homepage();
});
</script>
@stop

@section('content')
<div class="page-content container">

	<div class="searchform">
		{{ Form::open(array('url'=>'search', 'method'=>'get',)) }}
		<h2>Order food online from restaurants near you.</h2>
		<div class="clearfix">
			<div class="pull-left what-city">
				<div class="form-group">
					<label>Please enter your city</label>
					<input type="text" id="city-select" class="form-control" placeholder="Eg: Port-Harcourt">
					<input type="hidden" id="city">
				</div>
			</div>

			<div class="pull-left what-area">
				<div class="form-group">
					<label>What's your area?</label>
					<input type="text" id="area-select" class="form-control" placeholder="Eg: GRA Phase 1" disabled>
					<input type="hidden" name="area" id="area">
				</div>
			</div>
		</div>

		<div style="width: 60%; margin:0 auto;">
			<button class="btn btn-lg btn-block btn-warning find-btn">Find Restaurants</button>
		</div>
		{{ Form::close() }}

		<div class="order-tutorial clearfix">
			<div class="pull-left mascot"></div>
			<ul class="tutorial-steps pull-left">
				<li class="current">Search</li>
				<li>→ Pick a Restaurant</li>
				<li>→ Build Your Meal</li>
				<li>→ Order &amp; Chaw!</li>
			</ul>
			<p class="pull-left perks">Order from the convience of your home or office.  Pay cash on delivery.  Pickup at restaurant.  Free to use. Save your addresses</p>
		</div>
	</div>

	<div class="cuisine-search">
		<h2>Order from restaurants offering a wide range of cuisines</h2>
		<ul class="clearfix cuisine-list">
			<li>
				<div class="cuisine-icon">
					<a href="/search?cuisine=3">
						{{ HTML::image('assets/img/pizza-icon.png') }}
					</a>
				</div>
				<h3>Pizza</h3>
			</li>
			<li>
				<div class="cuisine-icon">
					<a href="/search?cuisine=2">
						{{ HTML::image('assets/img/nigerian-icon.png') }}
					</a>
				</div>
				<h3>Nigerian</h3>
			</li>
			<li>
				<div class="cuisine-icon">
					<a href="/search?cuisine=6">
						{{ HTML::image('assets/img/burger-icon-2x.png') }}
					</a>
				</div>
				<h3>Burgers</h3>
			</li>
			<li>
				<div class="cuisine-icon">
					<a href="/search?cuisine=4">
						{{ HTML::image('assets/img/sharwamma-icon.png') }}
					</a>
				</div>
				<h3>Sharwamma</h3>
			</li>
			<li>
				<div class="cuisine-icon">
					<a href="/search?cuisine=7">
						{{ HTML::image('assets/img/salad-icon.png') }}
					</a>
				</div>
				<h3>Salads</h3>
			</li>
			<li>
				<div class="cuisine-icon">
					<a href="/search?cuisine=8">
						{{ HTML::image('assets/img/pasteries-icon.png') }}
					</a>
				</div>
				<h3>Pasteries</h3>
			</li>
		</ul>
	</div>
</div>
@stop
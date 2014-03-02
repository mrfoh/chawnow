@section('title')
Chawnow | Online Food Ordering
@stop

@section('page_class') home-page @stop

@section('scripts')
{{ HTML::script('assets/js/plugins/typeahead.min.js') }}
{{ HTML::script('assets/js/frontend/views/home/index.js') }}
<script type="text/javascript">
Chawnow.data = { cities: {{ json_encode($cities) }}, areas: {{ json_encode($areas) }} };
$(document).ready(function() {
	var view = new Chawnow.Views.Homepage();
});
</script>
@stop

@section('content')
<div class="page-content container">

	<div class="homepage-top clearfix">
		<div class="search-box pull-left">
			<div class="search-box-inner">
				<h3>Start your order</h3>
				{{ Form::open(array("url"=>"search", "method"=>"get")) }}
					<div class="form-group">
						<input class="form-control" type="text" id="city-select" placeholder="Enter your city">
					</div>
					<div class="form-group">
						<input class="form-control" type="text" id="area-select" placeholder="Enter your area" disabled>
						<input type="hidden" name="area" id="area">
					</div>

					<div class="form-group">
						<button class="btn btn-lg btn-block btn-warning find-btn">FIND RESTAURANTS</button>
					</div>
				{{ Form::close() }}
			</div>
		</div>

		<div class="taglines pull-right">
			<div class="line first">
				<p>Chawnow is the best way to order</p>
			</div>
			<div class="line last">
				<p>food for delivery and pickup</p>
			</div>
		</div>
	</div>

	<div class="homepage-bottom clearfix">
		<div class="call-to-action pull-right">
			<h3>Own a restaurant?</h3>
			<p>With ChawNow, you can put your restaurant's menu online and recieve orders for delivery and pickups.</p>
			<p>ChawNow gives you tools to manage your menu, track orders, track user and bussiness analytics.</p>
			<a href="" class="btn btn-lg btn-warning">Find out more</a>
		</div>
	</div>
</div>
@stop
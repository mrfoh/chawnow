@section('title')
Chawnow | Online Food Ordering
@stop

@section('scripts')
<script type="text/javascript">
Chawnow.data = { cities: {{ json_encode($cities) }}, areas: {{ json_encode($areas) }} };
</script>
<script type="text/template" id="item-tmpl">
<li class="ui-screen-hidden" data-icon="false"><a href="#" data-name="<%= name %>" data-id="<%= id %>"><%= name %></a></li>
</script>
{{ HTML::script('assets/js/frontend/views/home/mobile.index.js') }}
<script type="text/javascript">
$(document).bind('pageinit', function() {
	var view = new Chawnow.Views.Homepage();
});
</script>
@stop

@section('content')
<div class="page" id="homepage">

	<div class="locale-select-box ui-shadow">
		<div class="inner">
			<h3>Find great food in your area</h3>
			{{ Form::open(array("url"=>"search", "method"=>"get", "data-ajax"=>"false")) }}
			<ul data-role="listview" data-filter="true" data-filter-placeholder="Enter your city" data-inset="true" id="cities"></ul>
		
			<ul data-role="listview" data-filter="true" data-filter-placeholder="Enter your area" data-inset="true" id="areas"></ul>
			<input type="hidden" name="area" id="area">

			<button type="submit">Find Restaurants</button>
			{{ Form::close() }}
		</div>
	</div>

	<div class="call-to-action">

		<div class="clearfix banner">
			<div class="pull-left banner-img">
				{{ HTML::image('assets/img/burger-icon.png') }}
			</div>
			<div class="pull-right banner-text">
				Order food for delivery or pickup from restaurants in your area.
			</div>
		</div>

		<ul class="steps">
			<li>Search</li>
			<li>Pick a restaurant</li>
			<li>Build your meal</li>
			<li>Order &amp; Chaw!</li>
		</ul>
	</div>
</div>
@stop
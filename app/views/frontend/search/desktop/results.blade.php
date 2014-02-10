@section('title')
Chawnow | Online Food Ordering
@stop

@section('page_class') search-results-page @stop

@section('description')
Order from the best local restaurants • Select your food from a large choice : pizza, sushi, American food... •  Fast and convenient •  Cash on delivery.
@stop

@section('scripts')
{{ HTML::script('assets/js/frontend/views/search/index.js') }}
<script type="text/javascript">
Chawnow.data = {search_params: {{ json_encode($params) }} }
</script>
<script type="text/javascript">
$(document).ready(function() {
	var view = new Chawnow.Views.Searchpage();
});
</script>
@stop

@section('content')
<div class="page-content container">
	<div class="row">
		<div class="col-md-3" id="filter-box">
			<h4>Filter Results</h4>
			{{ Form::open(array('url'=>"search", 'method'=>"get","id"=>"search-form")) }}
			<input type="hidden" name="area" value="{{ $area }}">
			<p class="filter-group-header">Cuisines</p>

			<ul>
			@foreach($cuisines as $cuisine)
			  <li>
			  	<div class="form-group">
			  		<div class="checkbox">
			  			<label>
			  				<input id="cuisine{{ $cuisine->id }}" type="checkbox" name="cuisine[]" value="{{ $cuisine->id }}">
			  				{{ $cuisine->name }} ({{ count($cuisine->restaurants) }})
			  			</label>
			  		</div>
			  	</div>
			  </li>
			@endforeach
			</ul>

			<p class="filter-group-header">Deliveries or Pickups</p>

			<ul>
				<li>
					<div class="form-group">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="deliveries" value="yes">
								Deliveries
							</label>
						</div>
					</div>
				</li>
				<li>
					<div class="form-group">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="pickups" value="yes">
								Pickups
							</label>
						</div>
					</div>
				</li>
			</ul>
			{{ Form::close() }}
		</div>

		<div class="col-md-9" id="results-box">
		@if($results)
			@if($results->getTotal() > 0)
			<div class=""></div>
			<ul class="result-list">
			@foreach($results as $result)
				<li class="item">
					<div class="item-top clearfix">
						<div class="item-info pull-left">
							<h4>{{ $result->name }}</h4>
							<p class="address">{{ $result->address }}</p>
						</div>
						<div class="item-rating pull-right">
						</div>
					</div>
					<div class="item-bottom clearfix">
						<div class="pull-left logo">{{ HTML::image($result->logo) }}</div>
						<div class="pull-left meta">
							<ul class="clearfix">
								<li><i class="icon icon-truck"></i> Deliveries: {{ ((bool) $result->meta->deliveries) ? "Yes": "No" }}</li>
								<li><i class="icon icon-home"></i> Pickups: {{ ((bool) $result->meta->pickups) ? "Yes": "No" }}</li>
								<li><i class="icon icon-money"></i> Delivery Fee: <b class="naira">N</b>{{ $result->meta->delivery_fee }}</li>
								<li><i class="icon icon-time"></i> Delivery In: {{ $result->meta->delivery_time }}</li>
								@if($result->meta->pickups == 1)
								<li><i class="icon icon-time"></i> Pickup In: {{ $result->meta->pickup_time }}</li>
								@endif
								<li><i class="icon icon-ok-circle"></i> Min Order: <b class="naira">N</b>{{ number_format($result->meta->minimium, 2) }}</li>
							</ul>
						</div>
						<div class="pull-right extra">
							<a href="{{ URL::to('restaurant/'.$result->slug) }}" class="btn btn-info btn-lg menu-link">Go to menu <i class="icon icon-caret-right icon-large"></i></a>
						</div>
					</div>
					<div class="item-status clearfix">
						<div class="pull-left"></div>
						<div class="pull-right">
							@if(Restaurants::status($result->id))
								<button type="button" class="btn btn-md btn-success">Open</button>
							@else
							<button type="button" class="btn btn-md btn-danger">Closed</button>
							@endif
						</div>
					</div>
				</li>
			@endforeach
			</ul>
			@else
			<div class="empty-results">
				<h3>:( Sorry no restaurants found</h3>
				<a href="/" class="btn btn-warning btn-lg">Start a new search</a>
			</div>
			@endif
		@else
			<div class="empty-results">
				<h3>:( Sorry no restaurants found</h3>
				<a href="/" class="btn btn-warning btn-lg">Start a new search</a>
			</div>
		@endif
		</div>
	</div>
</div>
@stop
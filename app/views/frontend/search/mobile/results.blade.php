@section('title')
Search Results | Chawnow | Online Food Ordering
@stop

@section('content')
<div class="page" id="search-results-page">
	<div class="results-page-header">
		@if($location)
		<strong>{{ ($results) ? $results->getTotal() : count($results) }} Restaurants found</strong><br>
		in {{ $location->city->name }}, {{ $location->name }}
		@else
		<strong>{{ ($results) ? $results->getTotal() : count($results) }} Restaurants found</strong><br>
		@endif
	</div>

	<div class="call-to-action">
		<p>Tap a restaurant to get started</p>
	</diV>

	<div class="results-box">
	@if($results)
		<ul class="restaurants" data-role="listview">
		@foreach($results as $restaurant)
		<li class="restaurant">
			<a href="/restaurant/{{ $restaurant->slug }}" data-ajax="false">
				{{ HTML::image($restaurant->logo) }}
				<h3>{{ $restaurant->name }}</h3>
				<p>{{ $restaurant->address }}</p>
				<p>
					@if((bool) $restaurant->meta->deliveries && (bool) $restaurant->meta->pickups) Delivery and Pickup 
					@elseif((bool) $restaurant->meta->deliveries) Delivery
					@elseif((bool) $restaurant->meta->pickups) Pickup @endif
				</p>
				<p>Min Order. <b class="naira">N</b>{{ number_format($restaurant->meta->minimium, 2) }}</p>
			</a>
		</li>
		@endforeach
		</ul>
	@else
		<div class="empty-results">
			<h3>:( Sorry no restaurants found</h3>
			<a href="/" class="ui-btn" data-ajax="false">Start a new search</a>
		</div>
	@endif
	</div>
</div>
@stop
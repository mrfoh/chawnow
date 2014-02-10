@section('title')
{{ $restaurant->name }} | Chawnow | Online Food Ordering
@stop

@section('scripts')
<script type="text/javascript">
Chawnow.data = {
	restaurant: { id: {{ $restaurant->id }} ,
				  name: "{{ $restaurant->name }}",
				  uid: "{{ $restaurant->slug }}",
				  status: {{ (int) $status }},
				  delivery_fee: {{ $restaurant->meta->delivery_fee }},
				  minimium: {{ $restaurant->meta->minimium }}
				}
}
</script>
<!-- Templates -->
<script type="text/template" id="cart-item-tmpl">
<li data-rowid="<%= rowid %>" class="clearfix ui-shadow">
	<div class="pull-left name">
		<%= name %><br>
		<b class="naira">N</b><%= Number(price).toFixed(2) %>
	</div>
	<div class="pull-right qty">
		<a href="#" class="ui-btn ui-btn-inline ui-icon-carat-d ui-btn-icon-notext reduce-qty" data-rowid="<%= rowid %>"></a>
		<a href="#" class="ui-btn ui-mini ui-btn-inline qty"><%= qty %></a>
		<a href="#" class="ui-btn ui-btn-inline ui-icon-carat-u ui-btn-icon-notext increase-qty" data-rowid="<%= rowid %>"></a>
	</div>
</li>
</script>
{{ HTML::script('assets/js/frontend/views/restaurant/mobile.index.js') }}

<script type="text/javascript">
$(document).bind('pageinit', function() {
	var view = new Chawnow.Views.RestaurantPage();
});
</script>
@stop

@section('content')
<div class="page" id="restaurant-page">
	<div class="restaurant-info">
		<h3>{{ $restaurant->name }}</h3>
		<p>
			@if((bool) $restaurant->meta->deliveries && (bool) $restaurant->meta->pickups) Delivery and Pickup 
			@elseif((bool) $restaurant->meta->deliveries) Delivery
			@elseif((bool) $restaurant->meta->pickups) Pickup @endif
		</p>
		<p>
			Min Order: <b class="naira">N</b>{{ number_format($restaurant->meta->minimium, 2) }}
			@if((bool) $restaurant->meta->deliveries)
			| Deivery Fee: <b class="naira">N</b>{{ number_format($restaurant->meta->delivery_fee, 2) }}
			@endif
		</p>
		<p>
			@if((bool) $restaurant->meta->deliveries)
			Delivery In: {{ $restaurant->meta->delivery_time }}
			@elseif((bool) $restaurant->meta->pickups)
			Pickup In: {{ $restaurant->meta->pickup_time }}
			@elseif((bool) $restaurant->meta->deliveries && (bool) $restaurant->meta->deliveries)
			Delivery In: {{ $restaurant->meta->delivery_time }} | Pickup In: {{ $restaurant->meta->pickup_time }}
			@endif
		</p>
		<div class="clearfix">
		</div>
	</div>
	
	<div data-role="tabs" id="tabs">
		<div data-role="navbar">
			<ul class="resturant-nav">
				<li><a href="#menus" class="ui-btn-active" data-ajax="false">Menus</a></li>
				<li><a href="#myorder" data-ajax="false">Your Order</a></li>
				<li><a href="#more-info" data-ajax="false">More Info</a></li>
			</ul>
		</div>

		<div id="menus" class="tablist-content">
			<div class="call-to-action">
				<p>Tap an item to add it to your order</p>
			</diV>

			<ul id="menu-list">
			@foreach($menus as $menu)
				<li class="menu-name ui-shadow">{{ $menu['name'] }}</li>
					@if($menu['categories'])
						@foreach($menu['categories'] as $category)
						<li class="category-name ui-shadow">{{ $category['name'] }}</li>
							<ul class="menu-items">
							@foreach($category['items'] as $item)
							<li class="clearfix item ui-shadow" data-id="{{ $item['id'] }}" data-item-name="{{ $item['name'] }}" data-price="{{ $item['price'] }}">
								<div class="item-name pull-left">{{ $item['name'] }}</div>
								<div class="item-price pull-right" style="font-size: .8em"><b class="naira">N</b>{{ number_format($item['price'], 2) }}</div>
							</li>
							@endforeach
							</ul>
						@endforeach
					@else
						<ul class="menu-items">
						@foreach($menu['items'] as $item)
							<li class="clearfix item ui-shadow" data-id="{{ $item['id'] }}" data-item-name="{{ $item['name'] }}" data-price="{{ $item['price'] }}">
								<div class="item-name pull-left">{{ $item['name'] }}</div>
								<div class="item-price pull-right" style="font-size: .8em"><b class="naira">N</b>{{ number_format($item['price'], 2) }}</div>
							</li>
						@endforeach
						</ul>
					@endif
			@endforeach
			</ul>
		</div>

		<div id="myorder" class="tablist-content user-cart">
			@if($cart_contents)
				<ul class="cart-contents">
					@foreach($cart_contents as $item)
					<li data-rowid="{{ $item['rowid'] }}" class="clearfix ui-shadow">
						<div class="pull-left name">
							{{ $item['name'] }}<br>
							<b class="naira">N</b>{{ number_format($item['price'],2) }}
						</div>
						<div class="pull-right qty">
							<a href="#" class="ui-btn ui-btn-inline ui-icon-carat-d ui-btn-icon-notext reduce-qty" data-rowid="{{ $item['rowid'] }}"></a>
							<a href="#" class="ui-btn ui-mini ui-btn-inline qty">{{ $item['qty'] }}</a>
							<a href="#" class="ui-btn ui-btn-inline ui-icon-carat-u ui-btn-icon-notext increase-qty" data-rowid="{{ $item['rowid'] }}"></a>
						</div>
					</li>
					@endforeach
					<li class="sub-total clearfix">
						<span class="pull-left"><strong>Sub Total</strong></span>
						<span class="pull-right"><b class="naira">N</b>{{ number_format($cart_total,2) }}</span>
					</li>
					<li class="sub-total clearfix">
						<span class="pull-left">+ Delivery Fee</span>
						<span class="pull-right"><b class="naira">N</b>{{ number_format($restaurant->meta->delivery_fee,2) }}</span>
					</li>
					<li class="sub-total clearfix">
						<span class="pull-left"><strong>Total</strong></span>
						<span class="pull-right"><b class="naira">N</b>{{ number_format($total,2) }}</span>
					</li>
				</ul>
			@else
				<ul class="cart-contents"></ul>
			@endif
				<div class="cart-actions" style="padding: .5em;">
					@if($status)
						@if($cart_total >= $restaurant->meta->minimium)
						<button type="button" class="ui-btn btn-success checkout-btn">Checkout Order</button>
						@else
						<button type="button" class="ui-btn btn-info checkout-btn" disabled="disbabled">Checkout Order</button>
						@endif
					@else
						<button type="button" class="ui-btn btn-info checkout-btn" disabled="disbabled">Checkout Order</button>
					@endif
				</div>
				<div class="cart-footer">
				@if($status)
					@if((bool) $restaurant->meta->deliveries)
					<p>Delivery in: {{ $restaurant->meta->delivery_time }}</p>
					@endif
					@if((bool) $restaurant->meta->pickups)
					<p>Pickup in: {{ $restaurant->meta->pickup_time }}</p>
					@endif
				@else
					<p>Restaurant is closed</p>
				@endif
				</div>
		</div>

		<div id="more-info" class="tablist-content">
			<div class="info-box">
				<div class="header">Contact</div>
				<div style="padding: 1em">
					<address>
					{{ $restaurant->address }}<br>
					<abbr title="Phone Number">Tel: </abbr> {{ $restaurant->phone }} <br>
					<abbr title="Email Address">Email: </abbr> {{ $restaurant->email }}
					</address>
				</div>
			</div>

			<ul id="hours" class="info-box">
				<li class="header">Hours</li>
				@foreach($schedules as $schedule)
				<li class="clearfix">
					<div class="day pull-left">{{ ucwords($schedule->day) }}</div>
					@if($schedule->open_time == "0:00" || $schedule->close_time == "0:00")
					<div class="time pull-right @if( date("D", time()) == date("D", strtotime($schedule->day)) ) active @endif">Closed</div>
					@else
					<div class="time pull-right  @if( date("D", time()) == date("D", strtotime($schedule->day)) ) active @endif">{{ $schedule->open_time }} - {{ $schedule->close_time }}</div>
					@endif
				</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@stop
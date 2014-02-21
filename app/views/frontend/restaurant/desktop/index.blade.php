@section('title')
{{ $restaurant->name }} | Chawnow | Online Food Ordering
@stop

@section('page_class') restaurant-page @stop

@section('description')
Order from {{ $restaurant->name }} . Order from the best local restaurants • Select your food from a large choice : pizza, sushi, American food... •  Fast and convenient •  Cash on delivery.
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
				},
	menus: {{ json_encode($menus) }},
	items: {{ json_encode($items) }}
}
</script>
<script type="text/template" id="menu-tmpl">
<a class="menu" data-id="<%= id %>" data-toggle="collapse" data-parent="#menus-list" href="#<%= slug %>-categories"><%= name %></a>
<% if(categories) { %>
	<ul class="categories collapse" id="<%= slug %>-categories" data-menu-id="<%=id %>">
	<% _.each(categories, function(category) { %>
		<li><a class="menu-category" href="" data-category="<%= category.name %>"><%= category.name %></a></li>
	<% }); %>
	</ul>
<% } %>
</script>
<script type="text/template" id="item-tmpl">
<div class="menu-item clearfix" data-menu-id="<%=menu.id %>" <% if(category) { %> data-category="<%= category.name %>" <% } %>>
	<div class="item-name pull-left"><%= name %></div>
	<div class="item-price pull-right">
		<span><b class="naira">N</b><%= price %></span>
		<button class="btn btn-sm btn-warning add-to-cart" data-id="<%= id %>" data-item-name="<%= name %>" data-item-price="<%= price %>"><i class="icon-plus-sign icon-large"></i></button>
	</div>
</div>
</script>
<script type="text/template" id="cart-item-tmpl">
<li data-rowid="<%= rowid %>" class="clearfix">
	<div class="pull-left">
		<div><%= name %></div>
		<div class="btn-group">
			<button type="button" class="btn btn-default btn-sm reduce-qty"  data-rowid="<%= rowid %>"><i class="icon-minus-sign"></i></button>
			<button type="button" class="btn btn-default btn-sm qty"><%= qty %></button>
			<button type="button" class="btn btn-default btn-sm increase-qty"  data-rowid="<%= rowid %>"><i class="icon-plus-sign"></i></button>
		</div>
	</div>
	<div class="pull-right"><b class="naira">N</b><%= Number(price).toFixed(2) %></div>
</li>
</script>
{{ HTML::script('assets/js/frontend/views/restaurant/index.js') }}
@stop

@section('content')
<div class="page-content container">
	<div class="row">
		<div class="col-md-9" id="restaurant-content">
			<div class="restaurant-content-top clearfix">
				<div class="restaurant-name pull-left">
					<h3>{{ $restaurant->name }}</h3>
				</div>

				<!-- <div class="restaurant-rating pull-right">
					<ul class="rating">
						<li><i class="icon-star icon-large"></i></li>
						<li><i class="icon-star icon-large"></i></li>
						<li><i class="icon-star icon-large"></i></li>
						<li><i class="icon-star icon-large"></i></li>
						<li><i class="icon-star icon-large"></i></li>
					</ul>
				</div> -->
			</div>
			<div class="restaurant-header clearfix">
				<div class="restaurant-logo pull-left">{{ HTML::image($restaurant->logo) }}</div>
				<div class="restaurant-info pull-left">
					<ul class="info-nav clearfix">
						<li class="active"><a href="#about" data-toggle="tab">About Us</a></li>
						<li><a href="#hours" data-toggle="tab">Delivery &amp; Pickup Hours</a></li>
						<li><a href="#info" data-toggle="tab">Info</a></li>
					</ul>
					<div class="tab-content" style="margin-top:10px;">
						<div class="tab-pane active" id="about">
							<p>{{ $restaurant->bio }}</p>
						</div>
						<div class="tab-pane" id="hours">
							<ul>
							@foreach($schedules as $schedule)
								<li class="clearfix">
									<div class="day pull-left">{{ ucwords($schedule->day) }}</div>
									@if($schedule->open_time == "0:00" || $schedule->close_time == "0:00")
										<div class="time pull-left @if( date("D", time()) == date("D", strtotime($schedule->day)) ) active @endif">Closed</div>
									@else
										<div class="time pull-left  @if( date("D", time()) == date("D", strtotime($schedule->day)) ) active @endif">{{ $schedule->open_time }} - {{ $schedule->close_time }}</div>
									@endif
								</li>
							@endforeach
							</ul>
						</div>
						<div class="tab-pane" id="info">
							<div class="clearfix">
								<div class="pull-left" style="width: 55%; padding: 10px;">
									<address>
									<i class="icon-map-marker"></i> {{ $restaurant->address }}<br>
									<i class="icon-telephone"></i><abbr title="Phone Number">Tel: </abbr> {{ $restaurant->phone }} <br>
									<i class="icon-enveloper"></i><abbr title="Email Address">Email: </abbr> {{ $restaurant->email }}
									</address>
								</div>
								<div class="pull-left" style="padding: 10px;">
									<ul style="list-style: none; margin: 0;">
										<li><i class="icon icon-truck"></i> Deliveries: {{ ((bool) $restaurant->meta->deliveries) ? "Yes": "No" }}</li>
										<li><i class="icon icon-home"></i> Pickups: {{ ((bool) $restaurant->meta->pickups) ? "Yes": "No" }}</li>
										<li><i class="icon icon-ok-circle"></i> Minimum Order: <b class="naira">N</b>{{ number_format($restaurant->meta->minimium, 2) }}</li>
										@if((bool) $restaurant->meta->deliveries)
										<li><i class="icon icon-money"></i> Delivery Fee: <b class="naira">N</b>{{ $restaurant->meta->delivery_fee }}</li>
										<li><i class="icon icon-time"></i> Delivery In: {{ $restaurant->meta->delivery_time }}</li>
										@endif

										@if((bool) $restaurant->meta->pickups)
										<li><i class="icon icon-time"></i> Pickup In: {{ $restaurant->meta->pickup_time }}</li>
										@endif
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="restaurant-menu clearfix">
				<div class="menus pull-left">
					<h3>Menus</h3>
					<ul class="menu-list" id="menus-list"></ul>
				</div>
				<div class="items pull-left">
					<h3 class="menu-title" style="display:none;"></h3>
					<ul class="item-list"></ul>
				</div>
			</div>
		</div>

		<div class="col-md-3 user-cart">
			<div class="cart-header">Your Order</div>
			<div class="cart-content">
				<div class="loading-indicator">
				    <i class="icon-spinner icon-spin icon-4x "></i>
				</div>
				@if($cart_contents)
				<ul class="cart-contents" style="display: block;">
					@foreach($cart_contents as $item)
					<li data-rowid="{{ $item['rowid'] }}" class="clearfix">
						<div class="pull-left">
							<div>{{ $item['name'] }}</div>
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-sm reduce-qty" data-rowid="{{ $item['rowid'] }}"><i class="icon-minus-sign"></i></button>
								<button type="button" class="btn btn-default btn-sm qty">{{ $item['qty'] }}</button>
								<button type="button" class="btn btn-default btn-sm increase-qty" data-rowid="{{ $item['rowid'] }}"><i class="icon-plus-sign"></i></button>
							</div>
						</div>
						<div class="pull-right"><b class="naira">N</b>{{ number_format($item['price'],2) }}</div>
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
				<div class="cart-actions">
					@if($status)
						@if($cart_total >= $restaurant->meta->minimium)
						<button type="button" class="btn btn-success btn-block checkout-btn">Checkout Order</button>
						@else
						<button type="button" class="btn btn-info btn-block checkout-btn" disabled="disbabled">Checkout Order</button>
						@endif
					@else
						<button type="button" class="btn btn-info btn-block checkout-btn" disabled="disbabled">Checkout Order</button>
					@endif
				</div>
			</div>
			<div class="cart-footer">
			@if($status)
				@if((bool) $restaurant->meta->deliveries)
				<p><i class="icon-time"></i> Delivery in: {{ $restaurant->meta->delivery_time }}</p>
				@endif
				@if((bool) $restaurant->meta->pickups)
				<p><i class="icon-time"></i> Pickup in: {{ $restaurant->meta->pickup_time }}</p>
				@endif
			@else
				<p>Restaurant is closed</p>
			@endif
			</div>
		</div>
	</div>
</div>
@stop
@foreach($menus as $menu)
<div class="tab-pane" id="{{ $menu['slug'] }}">
	<h2 class="menu-name">{{ $menu['name'] }}</h2>
	@if($menu['categories'])
		@foreach($menu['categories'] as $category)
		<div class="menu-category" data-id="{{ $category['id'] }}">
			<h3 class="category-name">{{ $category['name'] }}</h3>
			@if($category['groups'])

				@foreach($category['groups'] as $group)
					<h4 class="group-name">{{ $group['name'] }}</h4>
					@foreach($group['items'] as $item)
					<li>
						<div class="menu-item clearfix" data-menu-id="{{ $menu['id'] }}" data-category="{{ $category['id'] }}">
							<div class="clearfix">
								<div class="item-name pull-left">{{ $item['name'] }}</div>
								<div class="item-price pull-right">
									@if($item['options'])
									<span><b class="naira">N</b>{{ number_format($item['price'], 2) }}+</span>
									@else
									<span><b class="naira">N</b>{{ number_format($item['price'], 2) }}</span>
									@endif
									<button title="Click to add this to your order" class="btn btn-sm btn-warning add-to-cart" data-id="{{ $item['id'] }}" data-item-name="{{ $item['name'] }}" data-item-price="{{ $item['price'] }}" data-options="{{ ($item['options']) ? true : false }}">
										<i class="icon-plus-sign icon-large"></i>
									</button>
								</div>
							</div>
							<div class="item-description clearfix">{{ $item['description'] }}</div>
						</div>
					</li>
					@endforeach
				@endforeach

			@else

				@foreach($category['items'] as $item)
				<li>
					<div class="menu-item clearfix" data-menu-id="{{ $menu['id'] }}" data-category="{{ $category['id'] }}">
						<div class="clearfix">
							<div class="item-name pull-left">{{ $item['name'] }}</div>
							<div class="item-price pull-right">
								@if($item['options'])
								<span><b class="naira">N</b>{{ number_format($item['price'], 2) }}+</span>
								@else
								<span><b class="naira">N</b>{{ number_format($item['price'], 2) }}</span>
								@endif
								<button title="Click to add this to your order" class="btn btn-sm btn-warning add-to-cart" data-id="{{ $item['id'] }}" data-item-name="{{ $item['name'] }}" data-item-price="{{ $item['price'] }}" data-options="{{ ($item['options']) ? 'true': 'no' }}">
									<i class="icon-plus-sign icon-large"></i>
								</button>
							</div>
						</div>
						<div class="item-description clearfix">{{ $item['description'] }}</div>
					</div>
				</li>
				@endforeach
			@endif
		</div>
		@endforeach		

	@else
		@foreach($menu['items'] as $item)
		<li>
			<div class="menu-item clearfix" data-menu-id="{{ $menu['id'] }}" data-category="">
				<div class="clearfix">
					<div class="item-name pull-left">{{ $item['name'] }}</div>
					<div class="item-price pull-right">
						@if($item['options'])
						<span><b class="naira">N</b>{{ number_format($item['price'], 2) }}+</span>
						@else
						<span><b class="naira">N</b>{{ number_format($item['price'], 2) }}</span>
						@endif
						<button title="Click to add this to your order" class="btn btn-sm btn-warning add-to-cart" data-id="{{ $item['id'] }}" data-item-name="{{ $item['name'] }}" data-item-price="{{ $item['price'] }}" data-options="{{ ($item['options']) ? 'true': 'no' }}">
							<i class="icon-plus-sign icon-large"></i>
						</button>
					</div>
				</div>
				<div class="item-description clearfix">{{ $item['description'] }}</div>
			</div>
		</li>
		@endforeach
	@endif
</div>
@endforeach
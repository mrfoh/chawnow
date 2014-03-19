@section('title')
{{ $restaurantData->name }} | Menus
@stop

@section('scripts')
<script type="text/javascript">
	var menus = {{ json_encode($menus) }};
	var rid = {{ $restaurantData->id }};
</script>
<!-- Templates -->
<script type="text/template" id="menu-tmpl">
<div class="menu">
	<% if(active) { %>
		<a href="" data-id="<%= id %>" class="deactivate-menu" rel="tooltip" title="Click to deactivate menu"><div class="status-icon green"></div></a>
	<% } else { %>
		<a href="" data-id="<%= id %>" class="activate-menu"rel="tooltip" title="Click to activate menu"><div class="status-icon red"></div></a>
	<% } %>
	<a href="" data-slug="<%= slug %>" class="view-menu"><%= name %></a>
	<input type="text" class="name-inline-edit" data-id="<%= id %>">
	<div class="actions">
		<a href="" class="edit-menu" data-id="<%= id %>" rel="tooltip" title="Edit Menu"><i class="icon-pencil"></i></a>
		<a href="" class="remove-menu" data-id="<%= id %>" rel="tooltip" title="Delete Menu"><i class="icon-remove"></i></a>
	</div>
</div>
</script>


<script type="text/javascript" src="/assets/js/plugins/select2.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="/assets/js/libs/require.js" data-main="/assets/js/cpanel/menus/start"></script>
@stop

@section('content')
<div class="page-title">
	<h4>{{ $restaurantData->name }} - Menus</h4>
</div>

<div class="row-fluid" id="menus-app">
	<div class="span3">
		<div class="grid simple vertical green">
			<div class="grid-title clearfix">
				<div class="pull-left"><h4>Menus</h4></div>
				<div class="pull-right">
					<button type="button" class="btn btn-primary btn-small toogle-menu-form"><i class="icon-plus-sign"></i> New Menu</button>
				</div>
			</div>

			<div class="grid-body">
				<div class="control-group" id="menu-form" style="display:none;">
					<div class="controls">
						<input type="text" id="menu-name" placeholder="Menu name" class="span12">
						<select class="span12" id="menu-status">
							<option value="0">Inactive</option>
							<option value="1">Active</option>
						</select>
						<button type="button" class="btn btn-primary btn-block btn-medium" id="save-menu-btn">Save</button>
					</div>
				</div>
				<ul class="menu-list"></ul>
				<div class="menus-empty" style="display:none;">
					<h3>No menus created</h3>
				</div>

				<div class="alert alert-info">
					<p><div class="status-icon green"></div> -  Active Menu</p>
					<p><div class="status-icon red"></div> - Inactive Menu</p>
				</div>
			</div>
		</div>
	</div>

	<div class="span9">
		<div class="grid simple vertical green">
			<div class="grid-title clearfix">
				<div class="pull-left"><h4>Menu Items</h4></div>
				<div class="pull-right">
					<a href="/menus/item/add" class="btn btn-primary btn-small toggle-item-form"><i class="icon-plus-sign"></i> New Item</a>
				</div>
			</div>

			<div class="grid-body">
			@if($message)
				<div class="alert alert-info">{{ $message }}</div>
			@endif
			@if($items->getTotal() > 0)
				<ul class="item-list clearfix">
				@foreach($items as $item)
					<li class="item" data-id="{{ $item['id'] }}">
						<div class="details">
							<div class="name">
								<h3>
									@if((bool) $item['active'])
									<a href="" data-id="{{ $item['id'] }}" class="deactivate-item" rel="tooltip" title="Click to deactivate item"><div class="status-icon green"></div></a>
									@else
									<a href="" data-id="{{ $item['id'] }}" class="activate-item" rel="tooltip" title="Click to activate item"><div class="status-icon red"></div></a>
									@endif
									{{ $item['name'] }}
								</h3>
							</div>
							<div class="description">
								{{ $item['description'] }}
							</div>

							<ul class="meta">
								<li><strong>Menu: </strong>{{ $item['menu']['name'] }}</li>
								<li><strong>Category: </strong>{{ ($item['category']) ? $item['category']['name'] : "Uncatgorized" }}</li>
								<li><strong>Group: </strong>{{ ($item['group']) ? $item['group']['name'] : "Ungrouped" }}</li>
								<div style="width: 80%; margin: 10px auto !important;">
									<div class="btn-group">
										<a href="/menus/item/{{ $item['id'] }}" class="btn btn-white"><i class="icon-pencil"></i> Edit</a>
										<a href="/menus/items/{{ $item['id'] }}/delete" class="btn btn-white"><i class="icon-remove"></i> Delete</a>
									</div>
								</div>
							</ul>
						</div>
					</li>
				@endforeach
				</ul>

				{{ $items->links() }}
			@else
			@endif
			</div>
		</div>
	</div>

</div>
@stop
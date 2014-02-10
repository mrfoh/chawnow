@section('title')
{{ $restaurantData->name }} | Menus
@stop

@section('scripts')
<script type="text/javascript">
	var menus = {{ json_encode($menus) }};
	var menu_items = {{ json_encode($menu_items) }};
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
	<a href="" class="view-menu"><%= name %></a>
	<input type="text" class="name-inline-edit" data-id="<%= id %>">
	<div class="actions">
		<a href="" class="edit-menu" data-id="<%= id %>" rel="tooltip" title="Edit Menu"><i class="icon-pencil"></i></a>
		<a href="" class="remove-menu" data-id="<%= id %>" rel="tooltip" title="Delete Menu"><i class="icon-remove"></i></a>
	</div>
</div>
</script>
<script type="text/template" id="menu-item-tmpl">
<div class="menu-item" data-menu-name="<%= menu.name %>">
	<div class="item-name">
		<a href="" data-id="<%= id %>" rel="tooltip" title="Remove Item" class="remove-item"><i class="icon-remove"></i></a>
		<a href="" data-id="<%= id %>" rel="tooltip" title="Edit Item" class="edit-item"><i class="icon-pencil"></i></a>
		<h4>
		<% if(active) { %>
		<a href="" data-id="<%= id %>" class="deactivate-item" rel="tooltip" title="Click to deactivate item"><div class="status-icon green"></div></a>
		<% } else { %>
		<a href="" data-id="<%= id %>" class="activate-item"rel="tooltip" title="Click to activate item"><div class="status-icon red"></div></a>
		<% } %>
		<%= name %>
		</h4>
	</div>
	<div class="item-details">
		<ul>
			<li><i class="icon-money"></i> N<%= price %></li>
			<% if(category != null) { %>
			<li><i class="icon-reorder"></i> <%= category.name %></li>
			<% } else { %>
			<li><i class="icon-reorder"></i> Uncategorized</li>
			<% } %>
			<li><i class="icon-paste"></i> <%= menu.name %></li>
		</ul>
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
					<button type="button" class="close" data-dismiss="alert"></button>
					<p>Click on a menu to see its items</p>
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
					<button type="button" class="btn btn-primary btn-small toggle-item-form"><i class="icon-plus-sign"></i> New Item</button>
				</div>
			</div>

			<div class="grid-body">
				<ul class="item-list"></ul>
				<div class="menu-items-empty" style="display:none;">
					<h3>No items created</h3>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="menu-item-modal" role="dialog" aria-labelledby="menu-item-modelLabel" aria-hidden="true" data-mode="create">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<br>
			<h4 id="menu-item-modelLabel" class="semi-bold">Menu item</h4>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<div class="span8">
					<input type="text" class="span12" id="item-name" placeholder="Item Name">
				</div>
				<div class="span4">
					<input type="text" class="span12" id="item-price" placeholder="Item Price">
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6">
					<input type="hidden" id="item-menu" class="span12"></select>
				</div>
				<div class="span6">
					<input type="hidden" id="item-category" class="span12"></select>
					<a href="" class="new-trigger">+ New Category</a>
					<div class="new-form" style="display: none;">
						<input type="text" id="new-category-name" placeholder="Category Name" class="span12">
						<button class="btn btn-block btn-info" type="button" style="margin-bottom: 10px;" id="save-category-btn">Save Category</button>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6">
					<p>Status</p>
					<select id="item-status">
						<option value="1">Active</option>
						<option value="0">Inactive</option>
					</select>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button type="button" class="btn btn-primary" id="save-item-btn">Save</button>
		</div>
	</div>
</div>
@stop
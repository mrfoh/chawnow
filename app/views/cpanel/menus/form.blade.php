@section('title')
{{ $restaurantData->name }} | Menus | {{ ($action == "create") ? "New Menu Item" : "Edit Menu Item" }}
@stop

@section('scripts')
<script type="text/javascript">
	var menus = {{ json_encode($menus) }};
	var rid = {{ $restaurantData->id }};
</script>

{{ HTML::script('assets/js/plugins/select2.min.js') }}
{{ HTML::script('assets/js/cpanel/menus/form.js') }}

<!-- templates -->
<script type="text/template" id="option-tmpl">
<li>
<div class="option-name"><%= name %></div>
<div class="actions">
	<a href="" class="remove-option"><i class="icon-remove"></i></a>
</div>
<ul class="option-value-list clearfix"></ul>
<a href="#" class="toggle-value-form">+ New Value</a>
<div class="option-value-form">
	<input type="text" class="span4" id="option-value" placeholder="Option value">
	<input type="text" class="span4" id="option-value-price" placeholder="Option value price">
	<button type="button" class="btn btn-primary add-option-value"><i class="icon-plus-sign"></i></button>
</div>
<input type="hidden" class="option-data" name="option[]" value='<%= serialized %>'>
</li>
</script>

<script type="text/template" id="option-value-tmpl">
<li data-value="<%= value %>" data-price="<%= price %>">
	<div class="value-name"><%= value %>: <%= price %></div>
	<div class="actions" data-value="<%= value %>" data-price="<%= price %>">
		<a href="" class="remove-value"><i class="icon-remove"></i></a>
	</div>
</li>
</script>

<script type="text/javascript">
$(document).ready(function() {
	var view = new Cpanel.Views.ItemFormView();
});
</script>
@stop

@section('content')
<div class="page-title">
	<h4>{{ $restaurantData->name }} -  {{ ($action == "create") ? "New Menu Item" : "Edit Menu Item" }}</h4>
</div>

<div class="row-fluid" id="menu-item-form-app">

	<div class="span8 offset2">
		<div class="grid simple">

			<div class="grid-title">
				<h4>{{ ($action == "create") ? "New Menu Item" : "Edit Menu Item" }}</h4>
			</div>

			<div class="grid-body">
			@if($action == "create")
			{{ Form::open(array('url'=>"menus/item/add", 'method'=>"post")) }}
			@else
			{{ Form::open(array('url'=>"menus/item/".$id, 'method'=>"post")) }}
			@endif

			<div class="control-group">
				<label class="control-label">Name*</label>
				<span class="help">Name of the menu item (Eg. Egusi Soup)</span>
				<div class="controls">
					<input type="text" class="span12" name="name" id="name" placeholder="Name" value="{{ ($item) ? $item->name : '' }}">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Price*</label>
				<span class="help">Price of the menu item </span>
				<div class="controls">
					<input type="text" class="span12" name="price" id="price" placeholder="1000" value="{{ ($item) ? $item->price : '' }}">
				</div>
			</div>

			<div class="row-fluid">
				<div class="span6">
					<div class="control-group">
						<label class="control-label">Menu*</label>
						<span class="help">Select the menu the item belongs to</span>
						<div class="controls">
							<input type="hidden" id="menu_id" name="menu_id" value="{{ ($item) ? $item->menu_id : '' }}">
						</div>
					</div>
				</div>

				<div class="span6">
					<div class="control-group">
						<label class="control-label">Category</label>
						<span class="help">Select a menu category.</span>
						<div class="controls">
							<input type="hidden" id="menu_category_id" name="menu_category_id" value="{{ ($item) ? $item->menu_category_id : '' }}">
							<a href="" class="form-toggle">+ New Category</a>
							<div class="toggled-form">
								<input type="text" id="category-name" placeholder="Enter category name" >
								<button class="btn btn-primary" type="button" id="save-category">Save</button>
							</div>
						</div>
					</div>


					<div class="control-group">
						<label class="control-label">Group</label>
						<span class="help">Select a menu category group.</span>
						<div class="controls">
							<input type="hidden" id="item_group_id" name="item_group_id" value="{{ ($item) ? $item->item_group_id : '' }}">
							<a href="" class="form-toggle">+ New Category Group</a>
							<div class="toggled-form">
								<input type="text" id="group-name" placeholder="Enter group name">
								<button class="btn btn-primary" type="button" id="save-group">Save</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Description</label>
				<span class="help">A description of the item. (optional)</span>
				<div class="controls">
					<textarea class="span12" id="description" name="description" placeholder="Eg. Served with eba, fufu etc" rows="3">{{ ($item) ? $item->description : '' }}</textarea>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Item Options</label>
				<span class="help">Options for items.Eg Sauces, Swallows etc</span>
				<div class="controls options-box">
				@if($item)
					@if($item->options)
					<ul class="option-list">
						@foreach($item->options as $option)
						<li>
							<div class="option-name">{{ $option->name }}</div>
							<div class="actions">
								<a href="" class="remove-option"><i class="icon-remove"></i></a>
							</div>
							<ul class="option-value-list clearfix">
							@foreach($option->values as $value)
								<li data-value="{{ $value->value }}" data-price="{{ $value->price }}">
									<div class="value-name">{{ $value->value }} - {{ $value->price }}</div>
									<div class="actions" data-value="<%= value %>" data-price="<%= price %>">
										<a href="" class="remove-value"><i class="icon-remove"></i></a>
									</div>
								</li>
							@endforeach
							</ul>
							<a href="#" class="toggle-value-form">+ New Value</a>
							<div class="option-value-form">
								<input type="text" class="span4" id="option-value" placeholder="Option value">
								<input type="text" class="span4" id="option-value-price" placeholder="Option value price">
								<button type="button" class="btn btn-primary add-option-value"><i class="icon-plus-sign"></i></button>
							</div>
							<?php $optionsdata = array(
							'name'=>$option->name,'required'=> (bool) $option->required,
							'values'=> $option->values->toArray()); 
							?>
							<input type="hidden" class="option-data" name="option[]" value='{{ json_encode($optionsdata) }}'>
						</li>
						@endforeach
					</ul>
					@endif
				@else
					<ul class="option-list"></ul>
				@endif
					<div class="option-form">
						<input type="text" class="span12" id="option-name" placeholder="Option title (Eg. Select a swallow)"> <br/>
					
						<div style="margin: 0 auto; width: 200px; text-align: center;">
							<button class="btn btn-success add-option-btn" type="button"><i class="icon-plus-sign"></i> Add Option</button>
						</div>
					</div>

					<button class="btn btn-info toggle-option-form" type="button">New Option</button>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Active</label>
				<span class="help">Whether or not this item will be visible in your menu</span>
				<div class="controls">
					{{ Form::select('active', array(1=>"Active","0"=>"Inactive") ,($item) ? $item->active : 1, array('class'=>"span5")) }}
				</div>
			</div>

			<div class="form-actions">
				<button class="btn btn-large btn-danger" type="submit">Save</button>
			</div>
			{{ Form::close() }}
			</div>

		</div>
	</div>
</div>
@stop
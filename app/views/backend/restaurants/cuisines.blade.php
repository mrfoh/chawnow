@section('title')
Admin | Cuisines
@stop

@section('scripts')
{{ HTML::script('assets/js/backend/views/restaurants/cuisines.js') }}
<script type="text/javascript">
var cuisines = {{ json_encode($cuisines) }};
$(document).ready(function (){
	var View = new Backend.Views.CuisinesView();
});
</script>
<script type="text/template" id="cuisine-tmpl">
<li class="cuisine">
	<%= name %>
	<a href="#" class="remove-cuisine" title="Remove Cuisine" data-id="<%= id %>"><i class="icon-remove"></i></a>
</li>
</script>
@stop

@section('content')
<div class="page-title">
	<h4>Manage Cuisines</h4>
</div>

<div class="row-fluid" id="cuisines-page">
	<div class="span6">
		<div class="grid simple vertical green">
			<div class="grid-title">
				<h4>Cuisines</h4>
			</div>
			<div class="grid-body">
				<ul class="cuisine-list"></ul>
			</div>
		</div>
	</div>

	<div class="span6">
		<div class="grid simple vertical green">
			<div class="grid-title">
				<h4>Add Cuisine</h4>
			</div>
			<div class="grid-body">
				<div class="control-group">
					<div class="controls">
						<input type="text" id="name" placeholder="Enter a cuisine name" autocomplete="off" class="span12">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="text" id="slug" placeholder="Slug" autocomplete="off" disabled class="span12">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn btn-primray btn-block" id="add-btn">Add</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
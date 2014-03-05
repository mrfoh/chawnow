@section('title')
Admin | Restuarants | {{ $restaurant->name }} | Staff
@stop

@section('scripts')
<script type="text/javascript">
var staff = {{ json_encode($restaurant->staff->toArray()) }};
var users = {{ json_encode($users) }};
var rid = {{ $id }};
$(document).ready(function (){
	var View = new Backend.Views.RestuarantStaffView();
});
</script>
<script type="text/template" id="staff-tmpl">
<li class="staff">
	<%= user.first_name %> <%= user.last_name %>
	<a href="#" class="remove-staff" title="Remove Staff" data-id="<%= id %>"><i class="icon-remove"></i></a>
</li>
</script>
@stop

@section('content')
<div class="page-title">
	<h4>{{ $restaurant->name }} -  Manage Staff</h4>
</div>

<div class="row-fluid" id="restaurant-staff-page">
	<div class="span6">
		<div class="grid simple vertical green">
			<div class="grid-title">
				<h4>Restaurant Staff List</h4>
			</div>
			<div class="grid-body">
				<ul class="staff-list"></ul>
				<div class="empty" style="display:none">
					<h3>No staff found</h3>
				</div>
			</div>
		</div>
	</div>

	<div class="span6">
		<div class="grid simple vertical green">
			<div class="grid-title">
				<h4>Add Staff</h4>
			</div>
			<div class="grid-body">
				<div class="control-group">
					<div class="controls">
						<input type="text" id="name" placeholder="Enter a staff name" autocomplete="off">
						<button type="button" class="btn btn-default" id="add-btn">Add</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
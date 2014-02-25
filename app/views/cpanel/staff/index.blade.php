@section('title')
{{ $restaurantData->name }} | Staff
@stop

@section('scripts')
<script type="text/javascript">
var staff = {{ json_encode($staff->toArray()) }};
var currentUser = { id: {{ $currentUser->id }} }
</script>
<!-- Templates -->
<script type="text/template" id="staff-tmpl">
<div class="staff">
	<p class="staff-name"><%= user.first_name %> <%= user.last_name %></p>
	<div class="staff-user-groups">
	<% _.each(user.groups, function(group) { %>
		<p class="user-group"><%= group.name %></p>
	<% }) %>
	</div>
	<div class="staff-actions">
		<% if(!isAdmin && user.id != currentUser.id) {  %>
		<a href="#" class="remove-staff" rel="tooltip" title="Remove staff" data-user-id="<%= user.id %>" data-id="<% id %>"><i class="icon-remove"></i></a>
		<% } %>
	</div>
</div>
</script>
{{ HTML::script('assets/js/plugins/jquery.validate.min.js') }}
<script type="text/javascript" src="/assets/js/libs/require.js" data-main="/assets/js/cpanel/staff/start"></script>
@stop

@section('content')
<div class="page-title">
	<h4>{{ $restaurantData->name }} - Staff</h4>
</div>

<div class="row-fluid" id="staff-app">

	<div class="span4">
		<div class="grid simple vertical green">
			<div class="grid-title">
				<h4>Authorized Staff</h4>
			</div>
			<div class="grid-body" style="padding: 0 !important;">
				<ul class="staff-list"></ul>
				<div class="empty" style="display:none">
					<h3>No staff found</h3>
				</div>
			</div>
		</div>
	</div>

	<div class="span8">
		<div class="grid simple vertical green">
			<div class="grid-title">
				<h4>Add Staff</h4>
			</div>

			<div class="grid-body">
				<div class="alert alert-block alert-info">
					<h4 class="alert-heading"><i class="icon-warning-sign"></i> Heads Up!</h4>
					<p>You need to be a Restaurant Adminstrator to add new staff</p>
				</div>

				{{ Form::open(array("url"=>"staff/add", "method"=>"post", "id"=>"staff-form")) }}
					<div class="control-group">
						<label class="control-label">First Name</label>
						<div class="controls">
							<input type="text" class="span12" name="first_name" id="first_name" placeholder="John">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Last Name</label>
						<div class="controls">
							<input type="text" class="span12" name="last_name" id="last_name" placeholder="Doe">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Email Address</label>
						<div class="controls">
							<input type="text" class="span12" name="email" id="email" placeholder="johndoe@example.com">
						</div>
					</div>

					<div class="form-actions">
						<button class="btn btn-danger btn-cons btn-submit" type="submit">Add</button>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@stop
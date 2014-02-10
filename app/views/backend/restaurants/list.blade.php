@section('title')
Admin | Restaurants
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
	$('a.delete-restaurant').on('click', function (event) {
		var confirm = confirm("Are you sure you want to delete this restaurant");
		if(confirm === true)
			return true;
		
		return false;
	});
});
</script>
@stop

@section('content')
<div class="page-title">
	<h4>Restaurants</h4>
</div>

<div class="row-fluid">

	<div class="span12">
		<div class="grid simple">
			<div class="grid-title">
				<h4>Restuarant List</h4>
			</div>

			<div class="grid-body">
			@if($message)
			<div class="alert alert-info">
				<button class="close" data-dismiss="alert"></button>
				{{ $message }}
			</div>
			@endif

			@if($restaurants->getTotal() > 0)
				<table class="table table-hover no-more-tables">
					<thead>
						<tr>
							<th>
								<div class="checkbox check-default checkbox-circle">
									<input id="select-all" type="checkbox" class="checkall" />
									<label for="select-all"></label>
								</div>
							</th>
							<th>Name</th>
							<th>City</th>
							<th>Area</th>
							<th>Active</th>
							<th>Created At</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody>
						@foreach($restaurants as $restaurant)
						<tr>
							<td>
								<div class="checkbox check-default checkbox-circle">
									<input id="id" type="checkbox" name="id[]" value="{{ $restaurant->id }}" />
									<label for="id"></label>
								</div>
							</td>
							<td>{{ $restaurant->name }}</td>
							<td>{{ $restaurant->city->name }}</td>
							<td>{{ $restaurant->area->name }}</td>
							<td>{{ ($restaurant->active == 1) ? "Yes" : "No"}}</td>
							<td>{{ $restaurant->created_at }}</td>
							<td>
								<div class="btn-group">
                                    <button class="btn btn-white btn-demo-space"><i class="icon-cog"></i> Select Action</button>
                                    <button class="btn btn-white dropdown-toggle btn-demo-space" data-toggle="dropdown"> <span class="caret"></span> </button>
                                    <ul class="dropdown-menu">
                       					<li><a href="/restaurants/{{ $restaurant->id }}/edit">Edit</a></li>
										@if($restaurant->active == 1)
										<li><a href="/restaurants/{{ $restaurant->id }}/deactivate">Deactivate</a></li>
										@else
								        <li><a href="/restaurants/{{ $restaurant->id }}/activate">Activate</a></li>
									    @endif
									    <li><a href="/restaurants/{{ $restaurant->id }}/staff">Manage Staff</a></li>
									    <li><a href="/restaurants/{{ $restaurant->id }}/hours">Hours</a></li>
										<li><a href="/restaurants/{{ $restaurant->id }}/delete" class="delete-restaurant">Delete</a></li>
                                    </ul>
                                </div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<div class="empty" style="text-align:center;">
					<h3>No restaurants to display</h3>
					<a href="/restaurants/add" class="btn btn-large btn-primary">Add Restaurant</a>
				</div>
			@endif
			</div>
		</div>
	</div>

</div>
@stop
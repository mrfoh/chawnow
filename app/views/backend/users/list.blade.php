@section('title')
Admin | Users
@stop

@section('content')
<div class="page-title"><h3>Users</h3></div>

<div class="row-fluid">

	<div class="span12">
		<div class="grid simple">
			<div class="grid-title clearfix">
				<div class="pull-left">
					<h4>User List</h4>
				</div>

				<div class="pull-right">
					<div class="btn-group">
						<a href="/users/add" class="btn btn-primary">Add User</a>
						<button class="btn btn-danger">Delete</button>
					</div>
				</div>
			</div>

			<div class="grid-body">
			@if($users->getTotal() > 0)
				<table class="table table-hover no-more-tables">
					<thead>
						<tr>
							<th>
								<div class="checkbox check-default checkbox-circle">
									<input id="select-all" type="checkbox" class="checkall" />
									<label for="select-all"></label>
								</div>
							</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>User Group</th>
							<th>Last Login</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
					@foreach($users as $user)
						<tr>
							<td>
								<div class="checkbox check-default checkbox-circle">
									<input id="id" type="checkbox" name="id[]" value="{{ $user->id }}" />
									<label for="id"></label>
								</div>
							</td>
							<td>{{ $user->first_name }}</td>
							<td>{{ $user->last_name }}</td>
							<td>
								@foreach($user->groups as $group)
								{{ $group->name }}<br>
								@endforeach
							</td>
							<td>{{ $user->last_login }}</td>
							<td>
								<div class="btn-group">
									<a href="/users/{{ $user->id }}/edit" class="btn btn-info">Edit</a>
									<a href="" class="btn btn-primary">View</a>
									<a href="/users/{{ $user->id }}/delete" class="btn btn-danger">Delete</a>
								</div>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			@endif
			</div>
		</div>
	</div>

</div>
@stop
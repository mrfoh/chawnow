@section('title')
{{ $restaurantData->name }} | Staff
@stop

@section('content')
<div class="page-title">
	<h4>{{ $restaurantData->name }} - Staff</h4>
</div>

<div class="row-fluid" id="staff-app">
</div>
@stop
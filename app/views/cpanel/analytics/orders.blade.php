@section('title')
{{ $restaurantData->name }} | Analytics | Orders
@stop

@section('content')
<div class="page-title">
	<h4>{{ $restaurantData->name }} - Analytics</h4>
</div>

<div class="row-fluid" id="">
	<pre>
		<?php print_r($orders) ?>
	</pre>
</div>
@stop
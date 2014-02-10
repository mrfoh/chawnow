@section('title')
Admin | Restuarants | {{ $restaurant->name }} | Hours
@stop

@section('scripts')
{{ HTML::script('assets/js/plugins/bootstrap-timepicker.min.js') }}
<script type="text/javascript">
$(document).ready(function() {
	$('.timepicker-default').timepicker();
});
</script>
@stop

@section('content')
<div class="page-title">
	<h4>{{ $restaurant->name }} - Delivery &amp; Pick-up Hours</h4>
</div>

<div class="row-fluid" id="restaurant-schedule-page">

	<div class="grid simple vertical green">
		<div class="grid-title">
			<h4>Delivery &amp; Pick-Up Hours</h4>
		</div>

		<div class="grid-body">
		<p>Set times for opening and closing to 0:00 to signify the restaurant is closed on that day</p>
		{{ Form::open(array("url"=>"restaurants/".$id."/hours", "method"=>"post")) }}

		@foreach($restaurant->schedules as $schedule)
		<div class="control-group">
			<label class="control-label">{{ ucwords($schedule->day) }}</label>
			<div class="controls times">
					<div class="input-append bootstrap-timepicker-component clearfix">
			            <input type="text" class="timepicker-default span9" name="{{ $schedule->day }}_open_time" value="{{ $schedule->open_time }}">
			            <span class="add-on"><span class="arrow"></span><i class="icon-time"></i></span>
			        </div>
			        <div class="input-append bootstrap-timepicker-component clearfix">
			            <input type="text" class="timepicker-default span9" name="{{ $schedule->day }}_close_time" value="{{ $schedule->close_time }}">
			            <span class="add-on"><span class="arrow"></span><i class="icon-time"></i></span>
			        </div>
			</div>
		</div>
		@endforeach

		<div class="form-actions clearfix">
			<div class="pull-right">
				<button class="btn btn-danger btn-cons" type="submit"><i class="icon-ok"></i> Save</button>
				<a class="btn btn-white btn-cons" href="/restaurants">Cancel</a>
			</div>
		</div>
		{{ Form::close() }}
		</div>
	</div>
</div>
@stop
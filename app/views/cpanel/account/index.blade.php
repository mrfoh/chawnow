@section('title')
{{ $restaurantData->name }} | Account
@stop

@section('scripts')
{{ HTML::script('assets/js/plugins/plupload/moxie.min.js') }}
{{ HTML::script('assets/js/plugins/plupload/plupload.full.min.js') }}
{{ HTML::script('assets/js/plugins/jquery.validate.min.js') }}

<script type="text/javascript">
var locales = {{ json_encode($locales) }};
var cuisines = {{ json_encode($restaurant->cuisines->toArray()) }};
</script>
<script type="text/javascript" src="/assets/js/libs/require.js" data-main="/assets/js/cpanel/account/start"></script>
@stop

@section('content')
<div class="page-title">
	<h4>{{ $restaurantData->name }} | Account</h4>
</div>

<div class="row-fluid" id="account-app">
	<div class="span12">
	@if($errors->all())
		<div class="alert alert-danger">
		@foreach($errors->all() as $errormsg)
			{{ $errormsg }}
		@endforeach
		</div>
	@endif

	@if($message)
		<div class="alert alert-info">
		{{ $message }}
		</div>
	@endif

	{{ Form::open(array('url'=>"account/update", 'method'=>"post")) }}
	<div class="tabbable tabs-left">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">General Info</a></li>
				<li><a href="#options" data-toggle="tab">Options</a></li>
				<li><a href="#cuisines" data-toggle="tab">Cuisines</a></li>
			</ul>
			<div class="tab-content"><!-- .tab-content -->
				<div class="tab-pane active" id="general"><!-- #general -->

					<h3>General Information</h3>
					<div class="control-group">
						<label class="control-label">Logo</label>
						<div class="controls clearfix">
							<input type="hidden" name="logo" id="logo" value="{{ ($restaurant) ? $restaurant->logo: '' }}">
							<div class="logo-thumbnail pull-left">
								{{ ($restaurant) ? HTML::image($restaurant->logo) : "" }}
								<a href="" class="remove-trigger" title="Remove image" data-hide="true"><i class="icon-remove icon-large"></i></a>
							</div>
							<div class="uploader pull-left">
								<div class="btn-group">
									<button type="button" class="btn btn-white btn-demo-space">Change Logo</button>
									<button type="button" class="btn btn-white dropdown-toggle btn-demo-space" data-toggle="dropdown"> <span class="caret"></span> </button>
									<ul class="dropdown-menu">
										<li><a href="#" id="upload-trigger">Upload</a></li>
										<li><a href="" class="remove-trigger" data-hide="false">Remove</a></li>
									</ul>
								</div>
								<div class="well">
									<button type="button" class="btn btn-block btn-success" id="upload-btn" style="display: none;"><i class="icon-cloud-upload"></i> Upload</button>
									<ul>
										<li>Allowed file types: png, jpg, and gif</li>
										<li>Max File Size: 1mb</li>
										<li>Resolution: min 300x200px</li>
									</ul>
								</div>
							</div>
						</div> 
					</div>

					<div class="control-group">
						<label class="control-label">Restaurant Name</label>
						<div class="controls">
							<input class="span9" type="text" name="name" id="name" value="{{ ($restaurant) ? $restaurant->name: '' }}">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Restaurant Locale</label>
						<div class="controls">
							<select name="city" id="city" class="span5" data-select="{{ ($restaurant) ? $restaurant->city_id : 'none' }}">
								<option>Select City</option>
							</select>
							<select name="area" id="area" class="span5" disabled="disabled" data-select="{{ ($restaurant) ? $restaurant->area_id : 'none' }}">
								<option>Select Area</option>
							</select>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Address</label>
						<div class="controls">
							<textarea class="span6" name="address" id="address" rows="3">{{ ($restaurant) ? $restaurant->address : '' }}</textarea>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Email</label>
						<span class="help">Restaurant's contact email</span>
						<div class="controls">
							<input class="span6" type="text" name="email" id="email" value="{{ ($restaurant) ? $restaurant->email : '' }}">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Phone</label>
						<span class="help">Restaurant's contact phone number</span>
						<div class="controls">
							<input class="span6" type="text" name="phone" id="phone" value="{{ ($restaurant) ? $restaurant->phone : '' }}">
						</div>
					</div>					

					<div class="control-group">
						<label class="control-label">Description</label>
						<div class="controls">
							<textarea class="span9" name="bio" id="bio" rows="3">{{ ($restaurant) ? $restaurant->bio : '' }}</textarea>
						</div>
					</div>

					<div class="form-actions">
						<div class="pull-right">
							<button class="btn btn-danger btn-cons" type="submit"><i class="icon-ok"></i> Save</button>
							<a class="btn btn-white btn-cons" href="/users">Cancel</a>
						</div>
					</div>
				</div><!-- end #general -->
				<div class="tab-pane" id="options"> <!-- #options -->
					<h3>Options</h3>
					<div class="control-group">
						<label class="control-label">Deliveries &amp; Pickups</label>
						<div class="controls">
							<div class="checkbox check-warning">
		                      <input id="deliveries" name="deliveries" type="checkbox" value="1" data-checked="{{ ($restaurant) ? $restaurant->meta->deliveries : 'none' }}">
		                      <label for="deliveries">Deliveries (For restuarants that offer deliveries)</label>
		                    </div>
		                    <div class="checkbox check-danger">
		                      <input id="pickups" name="pickups" type="checkbox" value="1" data-checked="{{ ($restaurant) ? $restaurant->meta->pickups : 'none' }}">
		                      <label for="pickups">Pick-ups (For restuarants that offer pick-ups)</label>
		                    </div>
						</div>
					</div>

					<div class="control-group" id="logistics-info">
						<label class="control-label">Delivery &amp; Pickup Information</label>
						<div class="controls">
							<div id="delivery-info" class="info-group">
								<label for="delivery_fee">Delivery Fee</label>
								<input type="text" class="span5" placeholder="Delivery Fee: Eg: 500" name="delivery_fee" id="delivery_fee" value="{{ ($restaurant) ? $restaurant->meta->delivery_fee : "" }}">
								<label for="delivery_time">Delivery Time</label>
								<input type="text" class="span5" placeholder="Delivery Time: Eg: 45 minutes" name="delivery_time" id="delivery_time" value="{{ ($restaurant) ? $restaurant->meta->delivery_time : "" }}">
							</div>

							<div id="pickup-info" class="info-group">
								<label for="pickup_time">Pickup Time</label>
								<input type="text" class="span5" placeholder="Pick-up Time: Eg: 45 minutes" id="pickup_time" name="pickup_time" value="{{ ($restaurant) ? $restaurant->meta->pickup_time : "" }}">
							</div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Minimium Order</label>
						<span class="help">Set minimum order value</span>
						<div class="controls">
							<input type="text" name="minimuim_order" id="minimuim_order" placeholder="Eg: 2500" value="{{ ($restaurant) ? $restaurant->meta->minimium : "" }}">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Daily Order Limit</label>
						<span class="help">Set amount of orders allowed per day</span>
						<div class="controls">
							<input type="text" name="order_limit" id="order_limit" placeholder="Eg: 50" value="{{ ($restaurant) ? $restaurant->meta->order_limit : "" }}">
						</div>
					</div>

					<div class="form-actions">
						<div class="pull-right">
							<button class="btn btn-danger btn-cons" type="submit"><i class="icon-ok"></i> Save</button>
							<a class="btn btn-white btn-cons" href="/users">Cancel</a>
						</div>
					</div>
				</div><!-- end #options -->
				<div class="tab-pane clearfix" id="cuisines"><!-- #cuisines -->
					<h3>Cuisines</h3>
					<p>Tick cuisines your restaurant serves</p>

					@foreach($cuisines as $cuisine)
					<div class="control-group pull-left" style="min-width: 30%; margin-right: 1%;">
						<div class="controls">
							<div class="checkbox check-default">
								<input id="cuisine{{ $cuisine->id }}" type="checkbox" name="cuisine[]" value="{{ $cuisine->id }}">
								<label for="cuisine{{ $cuisine->id }}">{{ $cuisine->name }}</label>
							</div>
						</div>
					</div>
					@endforeach

					<div class="form-actions" style="clear:both;">
						<div class="pull-right">
							<button class="btn btn-danger btn-cons" type="submit"><i class="icon-ok"></i> Save</button>
							<a class="btn btn-white btn-cons" href="/users">Cancel</a>
						</div>
					</div>
				</div><!-- end #cuisines -->
			</div><!-- end .tab-content -->
		</div>
	{{ Form::close() }}
	</div>
</div>
@stop
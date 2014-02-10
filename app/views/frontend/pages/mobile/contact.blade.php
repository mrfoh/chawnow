@section('title')
Contact Us | Chawnow | Online Food Ordering
@stop

@section('content')
<div class="page" id="contact-page">

	<h3>How can we help you?</h3>

	<a data-rel="popup" class="ui-btn btn-warning ui-corner-all ui-shadow" href="#dinner-contact" data-transition="pop">I'm a Diner</a>
	<div data-role="popup" id="dinner-contact">
		<p>Email: <a href="mailto:hello@chawnow.com" data-ajax="false">hello@chawnow.com</a></p>
		<p>Phone: <a href="tel:07031017543" data-ajax="false">07031017543</a></p>
	</div>
	<div class="call-to-action clearfix">
		<div class="pull-left action-img">{{ HTML::image('assets/img/burger-icon.png') }}</div>
		<div class="pull-right action-text">
			Questions about an order, Help placing an order, Payment questions.
		</div>
	</div>

	<a data-rel="popup" class="ui-btn btn-warning ui-corner-all ui-shadow" href="#restaurant-contact">I'm a Restaurant</a>
	<div data-role="popup" id="restaurant-contact">
		<p>Email: <a href="mailto:restaurants@chawnow.com">restaurants@chawnow.com</a></p>
		<p>Phone: <a href="tel:07031017543" data-ajax="false">07031017543</a></p>
	</div>

	<div class="call-to-action clearfix">
		<div class="pull-left action-img">{{ HTML::image('assets/img/chef-icon.png') }}</div>
		<div class="pull-right action-text">
			Get your restaurant on Chawnow, Help updating your listings, General account questions.
		</div>
	</div>
</div>
@stop
@section('title')
Get in touch - Chawnow | Online Food Ordering 
@stop

@section('page_class') contact-page @stop

@section('content')
<div class="page-content container">

	<div class="row">
		<div class="col-md-12 contact-page-content">
			<div class="card contact-page-content clearfix">
				<div class="pull-left contact-details">
					<h2>How can we help you?</h2>

					<div class="clearfix customer-group-contact">
						<h3>I'm a Diner</h3>
						<div class="pull-left">
							{{ HTML::image('assets/img/burger-icon-2x.png') }}
						</div>
						<div class="pull-left can-do">
							<p>Questions about an order</p>
							<p>Help placing an order</p>
							<p>Payment questions</p>
						</div>

						<div class="pull-left can-do contact-info">
							<p>Email: <a href="">info@chawnow.com</a></p>
							<p>Phone: 07031017543</p>
						</div>
					</div>

					<div class="clearfix customer-group-contact">
						<h3>I'm a Restaurant</h3>
						<div class="pull-left">
							{{ HTML::image('assets/img/chef-icon-2x.png') }}
						</div>
						<div class="pull-left can-do">
							<p>Want to list you restaurant on Chawnow</p>
							<p>Help updating your menus</p>
							<p>General account questions</p>
						</div>
					</div>

					<div class="clearfix">
						<div class="pull-left dept-contact">
							<h3>Press Inquiries</h3>
							<p>Email: <a href="">press@chawnow.com</a></p>
						</div>

						<div class="pull-right dept-contact">
							<h3>General Inquiries</h3>
							<p>Email: <a href="">info@chawnow.com</a></p>
						</div>
					</div>
				</div>

				<div class="pull-right contact-form">
					<h3>Send us message</h3>
					<p>and we'll get back to you ASAP</p>
					{{ Form::open(array('url'=>"contact", 'method'=>"post")) }}
					<div class="form-group">
						<input type="text" class="form-control" name="name" id="name" placeholder="Your name">
					</div>

					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" class="form-control" name="email" id="email" placeholder="Your e-mail address">
					</div>

					<div class="form-group">
						<label for="subject">Subject</label>
						<input type="text" class="form-control" name="subject" id="subject" placeholder="Subject of your message">
					</div>

					<div class="form-group">
						<textarea class="form-control" id="message" name="message" rows="5" placeholder="Your message"></textarea>
					</div>

					<div class="form-group">
						<button class="btn btn-lg btn-warning btn-block" type="submit">Send Message</button>
					</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>

</div>
@stop
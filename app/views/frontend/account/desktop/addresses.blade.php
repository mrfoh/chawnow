@section('title')
My Addresses | Chawnow | Online Food Ordering
@stop

@section('page_class') account-page @stop

@section('description')
Order from the best local restaurants • Select your food from a large choice : pizza, sushi, American food... •  Fast and convenient •  Cash on delivery.
@stop

@section('scripts')
<script type="text/javascript">
Chawnow.data = { addresses: {{ json_encode($addresses->toArray()) }} };
</script>
<!-- Page Templates -->
<script type="text/template" id="address-tmpl">
<div class="address">
	<div class="name"><%= name %></div>
	<div class="address-text"><%= text %></div>
	<div class="actions">
		<a href="#" class="action delete-address" data-id="<%= id %>" title="Delete Address"><i class="icon-remove icon-large"></i></a>
	</div>
</div>
</script>
<!-- Page Script -->
{{ HTML::script('assets/js/frontend/views/account/addresses.js') }}
<!-- Page Initialize Code -->
<script type="text/javascript">
$(document).ready(function() {
	var view = new Chawnow.Views.AddressesPage();
});
</script>
@stop

@section('content')
<div class="page-content container">
	<div class="row">
		<div class="col-md-4 account-page-sidebar">
			<div class="card">
				<ul>
					<li><a href="/account">My Account</a></li>
					<li><a href="/account/orders">My Orders</a></li>
					<li class="active"><a href="/account/addresses">My Addresses</a></li>
					<li><a href="/account/password">Change Password</a></li>
				</ul>
			</div>
		</div>

		<div class="col-md-8 account-page-content">
			<div class="card">
				<div class="card-header">My Addresses</div>
				<div class="card-content">
					<ul class="address-list"></ul>
					<div class="toggle">
						<button type="button" class="btn btn-lg btn-info toggle-form" style="display: none;"><i class="icon-plus-sign"></i> New Address</button>
					</div>

					<div class="address-form">
						<form>
							<div class="form-group">
								<label for="name">Name: </label>
								<span class="help">A unique name for this address. Eg: Home</span>
								<input type="text" class="form-control" id="name" name="name">
							</div>

							<div class="form-group">
								<label for="name">Address: </label>
								<span class="help">The address. Eg: 2 El-dorado lane, Choba</span>
								<input type="text" class="form-control" id="text" name="text">
							</div>

							<div class="form-group">
								<button type="button" id="save-btn" class="btn btn-lg btn-info btn-block">Save</button>
							</div>
						</form>
					</div>

					<div class="empty" style="display: none;">
						<h3>You have not created any addresses</h3>
						<a href="#" class="btn btn-info btn-lg empty-toggle-form">Create an address</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
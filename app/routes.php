<?php
/*
|--------------------------------------------------------------------------
| Control Panel Routes
|--------------------------------------------------------------------------
*/

Route::group(array("domain" => Config::get('app.cpanel_url')), function()
{

	//Menus
	Route::get('menus', 'CpanelMenuController@index');
	Route::post('menus', 'CpanelMenuController@addMenu');
	Route::put('menus/{id}', 'CpanelMenuController@updateMenu');
	Route::delete('menus/{id}', 'CpanelMenuController@deleteMenu');
	Route::get('menus/activate/{id}', 'CpanelMenuController@activateMenu');
	Route::get('menus/deactivate/{id}', 'CpanelMenuController@deactivateMenu');

	//Menu Categories
	Route::post('menus/category', 'CpanelMenuController@addCategory');

	//Menu Items
	Route::post('menus/items', 'CpanelMenuController@addItem');
	Route::put('menus/items/{id}', 'CpanelMenuController@updateItem');
	Route::delete('menus/items/{id}', 'CpanelMenuController@removeItem');
	Route::get('menus/items/activate/{id}', 'CpanelMenuController@activateItem');
	Route::get('menus/items/deactivate/{id}', 'CpanelMenuController@deactivateItem');

	//Orders
	Route::get('orders/{status}', 'CpanelOrdersController@index');
	Route::get('orders/view/{id}', 'CpanelOrdersController@view');
	Route::get('orders/{id}/fulfill', 'CpanelOrdersController@fulfill');
	Route::get('orders', 'CpanelOrdersController@index');

	//Hours
	Route::post('hours/update', 'CpanelHoursController@update');
	Route::get('hours', 'CpanelHoursController@index');

	//Account
	Route::post('account/update','CpanelAccountController@update');
	Route::get('account', 'CpanelAccountController@index');

	//Staff
	Route::post('staff/add', 'CpanelStaffController@add');
	Route::get('staff/{id}/remove', 'CpanelStaffController@remove');
	Route::get('staff', 'CpanelStaffController@index');

	//Analytics
	Route::get('analytics/orders', 'CpanelAnaylticsController@orders');

	//User
	Route::get('user' , 'CpanelUserController@index');
	Route::post('user/update', 'CpanelUserController@updateUser');
	Route::get('user/change-password', 'CpanelUserController@showPasswordForm');
	Route::post('user/change-password', 'CpanelUserController@changePassword');

	//Authentication routes
	Route::get('login', 'CpanelAuthController@showLogin');
	Route::post('login', 'CpanelAuthController@login');
	Route::get('logout', function() {
		Sentry::logout();

		return Redirect::to('login');
	});

	//upload controller
	Route::any('upload','UploadController@index');

	Route::get('/', array('before' => 'cpanel_auth', 'uses' => 'CpanelHomeController@dashboard') );
});

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/

Route::group(array("domain" => Config::get('app.backend_url')), function()
{
	//Users
	Route::get('users', 'BackendUsersController@index');
	Route::get('users/add', 'BackendUsersController@form');
	Route::post('users/add', 'BackendUsersController@addUser');
	Route::get('users/{id}/edit', 'BackendUsersController@form');
	Route::post('users/{id}/edit', 'BackendUsersController@updateUser');
	Route::get('users/{id}/delete', 'BackendUsersController@deleteUser');

	//Restaurants
	Route::get('restaurants', 'BackendRestaurantController@index');

	Route::get('restaurants/add', 'BackendRestaurantController@form');
	Route::post('restaurants/add', 'BackendRestaurantController@add');

	Route::get('restaurants/{id}/edit', 'BackendRestaurantController@form');
	Route::post('restaurants/{id}/edit', 'BackendRestaurantController@update');

	Route::get('restaurants/{id}/activate', 'BackendRestaurantController@activate');
	Route::get('restaurants/{id}/deactivate', 'BackendRestaurantController@deactivate');

	Route::get('restaurants/{id}/staff', 'BackendRestaurantController@staff');
	Route::post('restaurants/{id}/staff/add', 'BackendRestaurantController@addStaff');
	Route::get('restaurants/{id}/staff/remove/{sid}', 'BackendRestaurantController@removeStaff');

	Route::get('restaurants/{id}/hours', 'BackendRestaurantController@hours');
	Route::post('restaurants/{id}/hours', 'BackendRestaurantController@updateHours');

	Route::get('restaurants/{id}/delete', 'BackendRestaurantController@delete');

	//Orders
	Route::get('orders/{status}', 'BackendOrderController@index');
	Route::get('orders/view/{id}', 'BackendOrderController@view');
	Route::get('orders', 'BackendOrderController@index@index');

	//Cuisines
	Route::get('cuisines', 'BackendCuisineController@index');
	Route::get('cuisines/remove/{id}', 'BackendCuisineController@remove');
	Route::post('cuisines/add', 'BackendCuisineController@add');

	//Analytics
	Route::get('analytics/orders', 'BackendAnalyticsController@orders');
	Route::get('analytics', 'BackendAnalyticsController@index');

	//upload controller
	Route::any('upload','UploadController@index');

	Route::get('/', 'BackendHomeController@dashboard');

	Route::get('login','BackendAuthController@showLogin');
	Route::post('login', 'BackendAuthController@login');
	Route::get('logout', function() {
		Sentry::logout();

		return Redirect::to('login');
	});

});


/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
//Restaurants
Route::get('restaurant/{slug}', 'RestaurantController@index');

//Cart
Route::get('cart/item/reduce-qty/{rowid}', 'CartController@reduceItemQty');
Route::get('cart/item/increase-qty/{rowid}', 'CartController@increaseItemQty');
Route::get('cart/clear', 'CartController@clear');
Route::post('cart/add', 'CartController@add');


//checkout
Route::get('checkout/{slug}', 'CheckoutController@index');
Route::post('checkout/{slug}', 'CheckoutController@placeOrder');

Route::get('order/{id}/verify', 'CheckoutController@verification');
Route::post('order/{id}/verify', 'CheckoutController@verify');
Route::get('order/{id}/complete', 'CheckoutController@complete');
Route::get('order/{id}/resend-verify', 'CheckoutController@resendVerificationCode');

//Account
Route::get('account/addresses/{id}/delete', 'AccountController@deleteAddress');
Route::get('account/orders/{id}/reorder', 'AccountController@reorder');
Route::post('account/addresses/{id}', 'AccountController@updateAddress');
Route::get('account/orders/{id}', 'AccountController@viewOrder');
Route::get('account/addresses', 'AccountController@addresses');
Route::post('account/addresses', 'AccountController@addAddress');
Route::post('account/update', 'AccountController@update');
Route::get('account/orders', 'AccountController@orders');
Route::get('account/password', 'AccountController@password');
Route::post('account/password', 'AccountController@changePassword');
Route::get('account', 'AccountController@index');

//Search
Route::get('search', 'SearchController@lookUp');
//Accounts
Route::get('signin', 'UserController@showSignin');
Route::get('signup', 'UserController@showSignup');
Route::post('signin', 'UserController@signin');
Route::post('signup', 'UserController@signup');

Route::get('about', 'PagesController@about');
//How it works
Route::get('how-it-works', 'PagesController@howItWorks');
//Contact
Route::get('contact', 'PagesController@contact');
//Faq
Route::get('faq', 'PagesController@faq');

Route::get('logout', function() {
	
	Sentry::logout();
	Session::flash('message','You have successfully been logged out of your account');

	return Redirect::to('signin');
});


Route::get('/', 'PagesController@home');

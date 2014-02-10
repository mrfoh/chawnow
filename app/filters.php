<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/
/*
Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});*/


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('auth', function()
{
	if(!Sentry::check())
		return Redirect::to('signin');
});

Route::filter('cpanel_auth', function()
{
	if(Sentry::check())
	{
		//get current user
		$user = Sentry::getUser();
		//get restaurant staff group
		$staff = Sentry::findGroupByName('Restaurant Staff');
		//if user is not in the group
		if(!$user->inGroup($staff))
		{
			Session::flash('message', 'Access denied, incorrect permissions');
			return Redirect::to('login');
		}
	}
	else
	{
		return Redirect::to('login');
	}
});

Route::filter('backend_auth', function()
{
	if(Sentry::check())
	{
		//get current user
		$user = Sentry::getUser();
		//get adminstrator group
		$admin = Sentry::findGroupByName('Administrator');
		//if user is not in the group
		if(!$user->inGroup($admin))
		{
			Session::flash('message', 'Access denied, incorrect permissions.');
			//redirect to login page
			return Redirect::to('login');
		}
	}
	else
	{
		Session::flash('message', 'Access denied, Please Login.');
		//redirect to login page
		return Redirect::to('login');
	}
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
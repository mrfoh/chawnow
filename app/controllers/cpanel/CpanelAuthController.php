<?php
	class CpanelAuthController extends Controller
	{
		public function showLogin()
		{
			//view data
			$this->viewdata['flashMessage'] = Session::get('message');
			//render view
			return View::make('cpanel.login', $this->viewdata);
		}

		public function login()
		{
			//Form attributes
			$attributes = Input::all();

			//validation rules
			$rules = array("email"=>"email|required", "password"=>"required");

			//validation
			$validation = Validator::make($attributes, $rules);
			//if validation fails
			if($validation->fails()) {
				return Redirect::to('login')->withErrors($validation);
			}
			//if validation is successfull
			else 
			{
				//Check if user is on staff list
				try {
					$user = Sentry::findUserByLogin(Input::get('email'));
				}
				catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
				{
					Session::flash('message', 'Invalid email address');
					return Redirect::to('login');
				}
				
				$staff = RestaurantStaff::where('user_id','=',$user->id)->get();
				if($staff)
				{
					try {

						$credentials = array(
							"email" => Input::get('email'),
							"password" => Input::get('password')
						);

						$remember = (bool) Input::get('remember', false);

						// Try to authenticate the user
		    			$user = Sentry::authenticate($credentials, $remember);

		    			if(count($staff) == 1)
		    				return Redirect::to('/');
		    			elseif(count($staff) > 1)
		    				return Redirect::to('restaurant-select');
		    		}
					catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
					{
					   Session::flash('message', 'Incorrect Password');
					   return Redirect::to('login');
					}
					catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
					{
						Session::flash('message', 'Invalid email and password combination');
					    return Redirect::to('login');
					}
					catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
					{
						Session::flash('message', 'This account has not been activated');
					    return Redirect::to('login');
					}
				}
				else
				{
					Session::flash('message', "Access Denied! You are not a restaurant's staff list");
					return Redirect::to('login');
				}
			}
		}
	}
<?php
	
	class BackendAuthController extends Controller
	{
		/**
		* Displays Login Form
		**/
		public function showLogin()
		{
			//view data
			$this->viewdata['flashMessage'] = Session::get('message');
			//render view
			return View::make('backend.login', $this->viewdata);
		}

		/**
		* Authenticates user
		**/
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

				try {

					$credentials = array(
						"email" => Input::get('email'),
						"password" => Input::get('password')
					);

					$remember = (bool) Input::get('remember', false);

					// Try to authenticate the user
	    			$user = Sentry::authenticate($credentials, $remember);

	    			return Redirect::to('/');
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
		}
	}
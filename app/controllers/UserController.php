<?php
	
	class UserController extends BaseController
	{
		public function __construct() 
		{
			parent::__construct();
			$this->layout = $this->setLayout('master');
		}

		public function showSignin()
		{
			$this->viewdata['message'] = Session::get('message');
			//render view
			$this->layout->content = View::make($this->viewpath('frontend.user.signin'), $this->viewdata);
		}

		public function showSignup()
		{
			$this->viewdata['message'] = Session::get('message');
			//render view
			$this->layout->content = View::make($this->viewpath('frontend.user.signup'), $this->viewdata);
		}

		public function signin()
		{
			//Form validation rules
			$validationRules = array(
				'email' => "required|email",
				'password' => "required"
			);
			//validation messages
			$validationMessages = array(
				'email.required'=>"Please enter your email",
				'email.email'=>"Please enter a valid email address"
			);
			//form attrinutes
			$attributes = Input::all();
			//form validator
			$validation = Validator::make($attributes, $validationRules, $validationMessages);
			//if validator fails
			if($validation->fails())
			{
				//flash input
				Input::flash();
				$redirecturl = Input::get('origin_url')  ? Input::get('origin_url') : 'signin';

				return Redirect::to($redirecturl)->withErrors($validation);
			}
			else
			{
				try
				{
					// Set login credentials
				    $credentials = array(
				        'email'    => Input::get('email'),
				        'password' => Input::get('password'),
				    );

				    if((bool) Input::get('remember'))
				    {
					    // Try to authenticate the user
					    $user = Sentry::authenticate($credentials, false);
					}
					else
					{
						$user = Sentry::authenticateAndRemember($credentials);
					}
					$redirecturl = Input::get('redirect_url') ? Input::get('redirect_url') : 'account';

				    return Redirect::to($redirecturl);
				}
				catch(Cartalyst\Sentry\Users\WrongPasswordException $e)
				{
					Session::flash('message', "Invalid Email and Password combination");

					$redirecturl = Input::get('origin_url')  ? Input::get('origin_url') : 'signin';

				    return Redirect::to($redirecturl);
				}
				catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
				{
					Session::flash('message', "Invalid Email and Password combination");

					$redirecturl = Input::get('origin_url')  ? Input::get('origin_url') : 'signin';

				    return Redirect::to($redirecturl);
				}
			}
		}

		public function signup()
		{
			//Form validation rules
			$validationRules = array(
				'first_name' => "required",
				'last_name' => "required",
				'email' => 'required|email',
				'mobile_no' => 'required|numeric',
				'password' => 'required'
			);
			//validation messages
			$validationMessages = array(
				'first_name.required' => 'Please enter your first name',
				'last_name.required' => 'Please enter your last name',
				'email.required' => 'Please enter your e-mail address',
				'email.email' => 'Please enter a valid e-mail address',
				'mobile_no.required' => 'Please enter your mobile number',
				'mobile_no.numeric' => 'Please enter a valid mobile no',
				'password.required' => 'Please enter a password'
			);
			//form attrinutes
			$attributes = Input::all();
			//form validator
			$validation = Validator::make($attributes, $validationRules, $validationMessages);
			//if validator fails
			if($validation->fails())
			{
				//flash input
				Input::flash();
				$redirecturl = Input::get('origin_url')  ? Input::get('origin_url') : 'signup';

				return Redirect::to($redirecturl)->withErrors($validation);
			}
			//Validation success
			else
			{
				
				try
				{
					//create user account
					$user = Sentry::createUser(array(
						'email' => Input::get('email'),
						'password' => Input::get('password'),
						'first_name' => Input::get('first_name'),
						'last_name' => Input::get('last_name'),
						'activated' => true
					));

					$redirecturl = Input::get('redirect_url') ? Input::get('redirect_url') : 'account';

					// Find the group using the group name
				    $group = Sentry::findGroupByName('Regular');

				    // Assign the group to the user
				    $user->addGroup($group);

				    //create profile
				    $profile = new Profile;
				    //profile attributes
				    $profile->user_id = $user->id;
				    $profile->mobile_no = Input::get('mobile_no');
				    //save profile
				    $profile->save();

				    //login user
				    Sentry::login($user, false);

				    //trigger user.registered event
				    Event::fire('user.registered', array("email"=>$user->email));

				    return Redirect::to($redirecturl);
				}
				catch (Cartalyst\Sentry\Users\UserExistsException $e)
				{
				    Session::flash('message','An account with this e-mail adddress already exists.');
				    $redirecturl = Input::get('origin_url')  ? Input::get('origin_url') : 'signup';

				    return Redirect::to($redirecturl);
				}
			}
		}

		public function signupFacebook()
		{

		}

		public function signinFacebook()
		{

		}
	}
<?php
	class BackendUsersController extends BackendController
	{
		//validation rules
		public $rules = array(
			"firstname"=>"required",
			"lastname"=>"required",
			"email"=>"required|email",
			"password"=>"required|min:6",
			"confpassword"=>"required|min:6|same:password"
		);

		public $editRules = array(
			"firstname"=>"required",
			"lastname"=>"required",
			"email"=>"required|email"
		);
		//validation messages
		public $messages = array(
			"firstname.required"=> "Please enter a first name",
			"lastname.required"=> "Please enter a last name",
			"email.required"=> "Please enter an e-mail address",
			"email.email"=> "Please enter a valid email address",
			"password.required"=> "Please enter a password",
			"password.min"=> "Your password must have at least 6 characters",
			"confpassword.required" => "Please confirm your password",
			"confpassword.min"=>"The password must have at least 6 characters",
			"confpassword.same"=>"Your passwords do not match"
		);

		/**
		* Displays a list of users on the database
		**/
		public function index() 
		{
			$perPage = 20;
			//view data
			$this->viewdata['users'] = User::with('groups')->paginate($perPage);
			//render view
			$this->layout->content = View::make('backend.users.list', $this->viewdata);
		}


		/**
		* Displays the user form
		**/
		public function form($id = null)
		{	
			//Build usergroups for groups select
			$groups = Group::all();
			foreach($groups as $group)
			{
				$usergroups[0] = "Select a user group";
				$usergroups[$group->id] = $group->name;
			}

			if(is_null($id))
			{
				$this->viewdata['action'] = "new";
				$this->viewdata['user'] = array();
			}
			else
			{
				$user =  Sentry::findUserById($id);
				$this->viewdata['action'] = "update";
				$this->viewdata['user'] = $user;
				$this->viewdata['id'] = $id;
				$this->viewdata['group'] =  $user->getGroups();
			}
			$this->viewdata['flashMessage'] = Session::get('message');
			$this->viewdata['groups'] = $usergroups;
			//render view
			$this->layout->content = View::make('backend.users.form', $this->viewdata);
		}

		/**
		* Creates new user on database
		**/
		public function addUser()
		{
			//form attributes
			$attributes = Input::all();
			//create validation object
			$validation = Validator::make($attributes, $this->rules, $this->messages);
			//if validation fails
			if($validation->fails())
			{
				//redirect to form with errors
				Input::flash(); //flash user input
				return Redirect::to('users/add')->withErrors($validation);
			}
			else
			{
				try
				{
					//Create user
					$user = Sentry::register(array(
						'email' => Input::get('email'),
						'password' => Input::get('password'),
						'first_name'=> Input::get('firstname'),
						'last_name' => Input::get('lastname')
					), true);
					// Find the group using the group id
				    $group = Sentry::findGroupById((int) Input::get('group'));
				    // Assign the group to the user
				    $user->addGroup($group);
				    return Redirect::to('users');
				}
				catch (Cartalyst\Sentry\Users\UserExistsException $e)
				{
				    $message = "A user with this email already exists";
				    Session::flash('message', $message);
				    return Redirect::to('users/add');
				}
			}
		}

		/**
		* Updates a user
		**/
		public function updateUser($id)
		{
			//form attributes
			$attributes = Input::all();
			//create validation object
			$validation = Validator::make($attributes, $this->editRules, $this->messages);
			//if validation fails
			if($validation->fails())
			{
				//redirect to form with errors
				Input::flash(); //flash user input
				return Redirect::to('users/'.$id.'/edit')->withErrors($validation);
			}
			else
			{
				//find the user
				$user = Sentry::findUserById($id);
				//update user details
				$user->first_name = Input::get('firstname');
				$user->last_name = Input::get('lastname');
				$user->email = Input::get('email');
				//update the user
				if($user->save())
				{
					$newgroup = Sentry::findGroupById((int) Input::get('group'));
					$user->addGroup($newgroup);

					return Redirect::to('users');
				}
			}
		}

		/**
		* Deletes a user
		**/
		public function deleteUser($id)
		{
			//find the user
			$user = Sentry::findUserById($id);
			//delete user
			$user->delete();

			return Redirect::to('users');
		}
	}
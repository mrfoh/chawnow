<?php
	
	class CpanelUserController extends CpanelController
	{

		public function index()
		{
			$this->viewdata['user'] = $this->user;
			$this->viewdata['message'] = Session::get('message');

			//render view
			$this->layout->content = View::make('cpanel.user.index', $this->viewdata);
		}

		public function updateUser()
		{
			$this->user->first_name = Input::get('first_name');
			$this->user->last_name = Input::get('last_name');
			$this->user->email = Input::get('email');

			if($this->user->save())
			{
				Session::flash('message', 'Your information was successfully updated.');
				return Redirect::to('user');
			}
 		}

		public function showPasswordForm()
		{
			$this->viewdata['message'] = Session::get('message');
			//render view
			$this->layout->content = View::make('cpanel.user.password', $this->viewdata);
		}

		public function changePassword()
		{
			$attributes = Input::all();

			$rules = array(
				'old_password' => "required",
				"new_password" => "required",
				"confpassword"=> "required|same:new_password"
			);

			$messages = array(
				'old_password.required' => "Please enter your old password",
				'new_password.required' => "Please enter a password",
				'confpassword.required' => "Please confirm your password",
				'confpassword.same' => "Your passwords do match"
			);

			$validation = Validator::make($attributes, $rules, $messages);

			if(!$validation->fails())
			{
				//if old password is correct
				if($this->user->checkPassword(Input::get('old_password')))
				{
					$this->user->password = Input::get('new_password');

					$this->user->save();

					Session::flash('message', 'Your password was changed successfully');
					return Redirect::to('user/change-password');
				}
				else
				{
					Session::flash('message', 'Your old password is incorrect');
					return Redirect::to('user/change-password');
				}
			}
			else
			{
				return Redirect::to('user/change-password')->withErrors($validation);
			}
		}
	}
<?php

	class CpanelStaffController extends CpanelController
	{
		public function index()
		{
			$this->viewdata['staff'] = Restaurants::staff($this->restaurant->id);
			$this->viewdata['currentUser'] = $this->user;
			
			$this->layout->content = View::make('cpanel.staff.index', $this->viewdata);
		}

		public function add()
		{
			$admin = Sentry::findGroupByName('Restaurant Admin');

			if($this->user->inGroup($admin))
			{
				try
				{
					//Create user
					$user = Sentry::register(array(
						'email' => Input::get('email'),
						'password' => $this->restaurant->slug,
						'first_name'=> Input::get('first_name'),
						'last_name' => Input::get('last_name')
					), true);
					// Get Restaurant Staff group
					$group = Sentry::findGroupByName('Restaurant Staff');
					// Assign the group to the user
					$user->addGroup($group);
					//Add to staff list
					$restaurantStaff = new RestaurantStaff;
					$restaurantStaff->restaurant_id = $this->restaurant->id;
					$restaurantStaff->user_id = $user->id;
					$restaurantStaff->save();
					//fetch new staff
					$staff = Restaurants::getStaff($this->restaurant->id, $user->id);
					return Response::json(array('status'=>"success","model"=>$staff->toArray()), 200);
				}
				catch (Cartalyst\Sentry\Users\UserExistsException $e)
				{
					$message = "A user with this email already exists";
					return Response::json(array('status'=>"error",'message'=>$message),200);
				}
			}
			else
			{
				$message = "You dont have permissions to add a new staff";
				return Response::json(array('status'=>"error",'message'=>$message));
			}
		}

		public function remove($userid)
		{
			$remove = Restaurants::removeStaff($this->restaurant->id, $userid);

			if($remove)
				return Response::json(array('status'=>"success"),200);
		}
	}
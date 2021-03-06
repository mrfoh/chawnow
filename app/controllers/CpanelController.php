<?php

	class CpanelController extends Controller 
	{
		public $layout = "cpanel.layouts.app";
		public $viewdata = array();
		public $restaurant;

		public function __construct()
		{
			$this->beforeFilter('cpanel_auth');
		}

		/**
		* Setup the layout used by the controller.
		*
		* @return void
		*/
		protected function setupLayout()
		{
			if ( ! is_null($this->layout))
			{
				$this->setGlobalViewdata();
				$this->layout = View::make($this->layout);
			}
		}

		protected function setGlobalViewdata()
		{
			//current user
			$user = Sentry::getUser();
			if($user)
			{
				//check if restaurant is set in session
				$checkRestaurant = Session::get('restaurant');
				if($checkRestaurant) {
					$this->restaurant = Restaurants::findById((int) $checkRestaurant);
				}
				else {
					//get user restaurant
					$restaurant = Restaurants::findByStaffId($user->id);
					//set restaurant
					$this->restaurant = $restaurant;
				}
			
				//set user
				$this->user = $user;
				//Global view data
				View::share('firstname',$user->first_name);
				View::share('lastname', $user->last_name);
				View::share('status', Restaurants::status($this->restaurant->id));
				View::share('restaurantData', $this->restaurant);
			}
		}
	}
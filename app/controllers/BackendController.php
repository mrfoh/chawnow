<?php

	class BackendController extends Controller 
	{
		public $viewdata = array();

		/**
		* Controller Layout
		*/
		public $layout = "backend.layouts.app";

		public function __construct()
		{
			$this->beforeFilter('backend_auth');
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
			//get current logged user
			$user = Sentry::getUser();
			if($user)
			{
				//Set global data
				View::share('firstname',$user->first_name);
				View::share('lastname', $user->last_name);
			}
		}
	}
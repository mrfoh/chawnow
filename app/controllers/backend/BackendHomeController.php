<?php
	
	class BackendHomeController extends BackendController
	{
		/**
		* Backend Dashboard
		**/
		public function dashboard()
		{
			//render view
			$this->layout->content = View::make('backend.dashboard');
		}
	}
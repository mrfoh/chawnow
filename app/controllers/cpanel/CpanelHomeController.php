<?php
	
	class CpanelHomeController extends CpanelController
	{	
		public function dashboard()
		{
			//render view
			$this->layout->content = View::make('cpanel.dashboard');
		}
	}
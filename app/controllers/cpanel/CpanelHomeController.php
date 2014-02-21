<?php
	
	class CpanelHomeController extends CpanelController
	{	
		public function dashboard()
		{
			$this->viewdata['setupProgress'] = Restaurants::setupProgress($this->restaurant->id);
			//render view
			$this->layout->content = View::make('cpanel.dashboard', $this->viewdata);
		}
	}
<?php

	class CpanelStaffController extends CpanelController
	{
		public function index()
		{
			$this->layout->content = View::make('cpanel.staff.index', $this->viewdata);
		}
	}
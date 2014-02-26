<?php

	use Carbon\Carbon;

	class CpanelAnaylticsController extends CpanelController
	{
		public function orders()
		{
			$orders = SysAnalytics::queryOrders($this->restaurant->id);
			$this->viewdata['orders'] = $orders;

			$this->layout->content = View::make('cpanel.analytics.orders', $this->viewdata);
		}

		public function test()
		{
			
		}
	}
<?php
use Carbon\Carbon;
	
	class BackendAnalyticsController extends BackendController
	{
		public function orders()
		{

			$orders = SysAnalytics::queryOrders();
			$this->viewdata['orders'] = $orders;

			$this->layout->content = View::make('backend.analytics.orders', $this->viewdata);
		}
	}
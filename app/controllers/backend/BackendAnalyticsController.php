<?php
use Carbon\Carbon;
	
	class BackendAnalyticsController extends BackendController
	{
		public function orders()
		{

			$monthsOrders = SysAnalytics::queryOrders();
			$weeksOrders = SysAnalytics::queryOrders('week');
			//$daysOrders = SysAnalytics::queryOrders('day');

			$monthsOrderDistribution = SysAnalytics::queryOrderDistribution();
			$weeksOrdersDistribution = SysAnalytics::queryOrderDistribution('week');

			$this->viewdata['orders'] = array(
				'month' => $monthsOrders,
				'week' => $weeksOrders,
				//'day' => $daysOrders
			);

			$this->viewdata['orderDistribution'] = array(
				'month' => $monthsOrderDistribution,
				'week' => $weeksOrdersDistribution
			);

			$this->layout->content = View::make('backend.analytics.orders', $this->viewdata);
		}
	}
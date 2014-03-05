<?php

	use Carbon\Carbon;

	class CpanelAnaylticsController extends CpanelController
	{
		public function orders()
		{
			$orders = SysAnalytics::queryRestaurantOrders($this->restaurant->id);
			$orderDistrubitions = SysAnalytics::queryRestaurantOrderDistribution($this->restaurant->id);

			$this->viewdata['orders'] = $orders;
			$this->viewdata['distribution'] = $orderDistrubitions;

			$this->layout->content = View::make('cpanel.analytics.orders', $this->viewdata);
		}

		public function orderQuery()
		{
			$range = Input::get('range', 'month');
			$status = Input::get('status', 'all');

			$data = SysAnalytics::queryRestaurantOrders($this->restaurant->id, $range, $status);

			return Response::json( array("data"=>$data, "params"=>array("range"=>$range, "status"=>$status)) );
		}

		public function orderDistributionQuery()
		{
			$range = Input::get('range', 'month');

			$data = SysAnalytics::queryRestaurantOrderDistribution($this->restaurant->id, $range);

			return Response::json(array("data"=>$data, "params"=>array("range"=>$range)));
		}
	}
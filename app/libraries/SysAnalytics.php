<?php
	use Carbon\Carbon;

	class SysAnalytics
	{
		private static function dateRange($range)
		{
			$carbon = new Carbon;

			switch ($range) {
				case 'day':
					$queryRange = $carbon::now()->subDay();
					break;

				case 'week':
					$queryRange = $carbon::now()->subDays(7);
					break;

				case 'month':
					$queryRange = $carbon::now()->subDays(30);
					break;
			}

			return $queryRange;
		}

		public static function formatOrders($orders, $range = "month")
		{
			if($orders)
			{
				foreach ($orders as $order) {
					$data[] = array('day'=> date("Y-m-d", strtotime($order->created_at)), 'orders'=>$order->orders);
				}

				return $data;
			}
			else
			{
				return array();
			}
		}

		public static function queryOrders($range = "month", $status = "all")
		{
			$queryRange = self::dateRange($range);

			$orders = Order::where('created_at' ,'>=', $queryRange)
							->groupBy('date')
							->orderBy('date', 'asc')
							->get(array(
								'status', 'created_at', DB::raw('Date(created_at) as date'), DB::raw('COUNT(*) as "orders"')
							));

			return self::formatOrders($orders);	
		}
	}
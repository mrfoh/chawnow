<?php
	use Carbon\Carbon;

	class SysAnalytics
	{
		private static function dateRange($range)
		{
			$carbon = new Carbon;

			switch ($range) {
				case 'day':
					$queryRange = $carbon::now()->subHours(24);
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

		/**
		* Format order query result for presentation
		* @access private
		* @param objects $orders
		* Order model objects
		* @return array 
		**/
		public static function formatOrders($orders, $range)
		{
			if($orders)
			{
				foreach ($orders as $order) {
					if($range == "month" || $range == "week")
						$data[] = array('day'=> date("Y-m-d", strtotime($order->created_at)), 'orders'=>$order->orders);
					elseif($range == "day")
						$data[] = array('day'=> date("h:iA", strtotime($order->created_at)), 'orders'=>$order->orders);
				}

				return $data;
			}
			else
			{
				return array();
			}
		}

		public static function formatOrderDistribution($orders)
		{
			if($orders)
			{
				$data['fulfilled'] = array();
				$data['verified'] = array();
				$data['placed'] = array();

				foreach($orders as $order)
				{
					if($order->status == "fulfilled")
						$data['fulfilled'][] = $order;

					elseif($order->status == "verified")
						$data['verified'][] = $order;

					elseif($order->status == "placed")
						$data['placed'][] = $order;
				}

				$distribution = array(
					"fulfilled"=> count($data['fulfilled']),
					"verified"=> count($data['verified']),
					"placed"=> count($data['placed'])
				);

				return $distribution;
			}
			else
			{
				return array();
			}
		}

		/**
		* Query database for orders within a time range from current date
		* @access public
		* @param string $range
		* Default - month
		* Options - week, day
		* @param string $status
		* Default - all
		* Options - placed, verified, fulfilled
		* @return array
		**/
		public static function queryOrders($range = "month", $status = "all")
		{
			$queryRange = self::dateRange($range);

			if($status == "all")
			{
				$orders = Order::where('created_at' ,'>=', $queryRange)
							    ->groupBy('date')
							    ->orderBy('date', 'asc')
							    ->get(array(
								'status', 'created_at', DB::raw('Date(created_at) as date'), DB::raw('COUNT(*) as "orders"')
							));

			}

			elseif ($status == "placed") 
			{
				$orders = Order::where('created_at' ,'>=', $queryRange)
								->where('status', '=', 'placed')
							    ->groupBy('date')
							    ->orderBy('date', 'asc')
							    ->get(array(
								'status', 'created_at', DB::raw('Date(created_at) as date'), DB::raw('COUNT(*) as "orders"')
							));
			}

			elseif ($status == "verified") 
			{
				$orders = Order::where('created_at' ,'>=', $queryRange)
								->where('status', '=', 'verified')
							    ->groupBy('date')
							    ->orderBy('date', 'asc')
							    ->get(array(
								'status', 'created_at', DB::raw('Date(created_at) as date'), DB::raw('COUNT(*) as "orders"')
							));
			}

			elseif ($status == "fufilled") 
			{
				$orders = Order::where('created_at' ,'>=', $queryRange)
								->where('status', '=', 'fufilled')
							    ->groupBy('date')
							    ->orderBy('date', 'asc')
							    ->get(array(
								'status', 'created_at', DB::raw('Date(created_at) as date'), DB::raw('COUNT(*) as "orders"')
							));
			}

			//Format db results
			return self::formatOrders($orders, $range);	
		}

		public static function queryOrderDistribution($range = "month")
		{
			$queryRange = self::dateRange($range);

			$orders = Order::where('created_at', '>=', $queryRange)
							->orderBy('status', 'asc')
							->get(array('status', 'created_at'));

			return self::formatOrderDistribution($orders);
		}

		/**
		* Query database for a restaurants orders within a time range from current date
		* @access public
		* @param integer $id
		* Restaurant ID
		* @param string $range
		* Default - month
		* Options - week, day
		* @param string $status
		* Default - all
		* Options - placed, verified, fulfilled
		* @return array
		**/
		public static function queryRestaurantOrders($id, $range = "month", $status = "all")
		{
			$queryRange = self::dateRange($range);

			if($status == "all")
			{
				$orders = Order::where('created_at' ,'>=', $queryRange)
								->where('restaurant_id','=', 1)
							    ->groupBy('date')
							    ->orderBy('date', 'asc')
							    ->get(array(
								'status', 'created_at', DB::raw('Date(created_at) as date'), DB::raw('COUNT(*) as "orders"')
							));

			}

			elseif ($status == "placed") 
			{
				$orders = Order::where('created_at' ,'>=', $queryRange)
								->where('restaurant_id','=', 1)
								->where('status', '=', 'placed')
							    ->groupBy('date')
							    ->orderBy('date', 'asc')
							    ->get(array(
								'status', 'created_at', DB::raw('Date(created_at) as date'), DB::raw('COUNT(*) as "orders"')
							));
			}

			elseif ($status == "verified") 
			{
				$orders = Order::where('created_at' ,'>=', $queryRange)
								->where('restaurant_id','=', 1)
								->where('status', '=', 'verified')
							    ->groupBy('date')
							    ->orderBy('date', 'asc')
							    ->get(array(
								'status', 'created_at', DB::raw('Date(created_at) as date'), DB::raw('COUNT(*) as "orders"')
							));
			}

			elseif ($status == "fufilled") 
			{
				$orders = Order::where('created_at' ,'>=', $queryRange)
								->where('restaurant_id','=', 1)
								->where('status', '=', 'fufilled')
							    ->groupBy('date')
							    ->orderBy('date', 'asc')
							    ->get(array(
								'status', 'created_at', DB::raw('Date(created_at) as date'), DB::raw('COUNT(*) as "orders"')
							));
			}



			return self::formatOrders($orders, $range);	
		}
	}
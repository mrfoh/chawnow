<?php

	use Carbon\Carbon;

	class CpanelAnaylticsController extends CpanelController
	{
		public function index()
		{
			$carbon = new Carbon;
			$range = $carbon::now()->subMonth();

			$orders = Order::where('created_at' ,'>=', $range)
							->groupBy('date')
							->orderBy('date', 'desc')
							->get(array(
								DB::raw('Date(created_at) as date'), DB::raw('COUNT(*) as "orders"')
							));

			$this->viewdata['orders'] = $orders;
			$this->layout->content = View::make('cpanel.analytics.index', $this->viewdata);
		}
	}
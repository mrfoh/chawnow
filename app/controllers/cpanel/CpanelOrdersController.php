<?php
	
	class CpanelOrdersController extends CpanelController
	{
		public function index($status = "all")
		{
			$orders = Orders::restaurant($this->restaurant->id, $status);
			
			$this->viewdata['orders'] = $orders;
			$this->viewdata['status'] = $status;

			$this->layout->content = View::make('cpanel.orders.index', $this->viewdata);
		}

		public function view($id)
		{
			$this->viewdata['order'] = Orders::get($id);

			$this->layout->content = View::make('cpanel.orders.view', $this->viewdata);
		}

		public function fulfill($id)
		{
			$fulfill = Orders::fulfill($id);

			if($fulfill)
				return Redirect::to('orders/view/'.$id);
		}
	}
<?php
	
	class BackendOrderController extends BackendController
	{
		public function index($status = "all")
		{
			$orders = Orders::all($status);
			
			$this->viewdata['orders'] = $orders;
			$this->viewdata['status'] = $status;
		
			$this->layout->content = View::make('backend.orders.index', $this->viewdata);
		}

		public function view($id)
		{
			$this->viewdata['order'] = Orders::get($id);

			$this->layout->content = View::make('backend.orders.view', $this->viewdata);
		}
	}
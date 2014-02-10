<?php
	class RestaurantController extends BaseController
	{

		public function __construct() 
		{
			parent::__construct();
			$this->layout = $this->setLayout('master');
		}

		public function index($slug)
		{	
			//find restaurant
			$restaurant = Restaurants::findBySlug($slug);
			if($slug && $restaurant)
			{	

				$existing = Session::get('activecart');
				if($existing)
				{
					if($existing == $slug)
					{
						$contents = Shpcart::cart($existing)->contents();
						$carttotal = Shpcart::cart($existing)->total();
					}
					else
					{
						Shpcart::cart($existing)->destroy();
						$contents = array();
						$carttotal = 0.00;
					}
				}
				else 
				{
					$contents = array();
					$carttotal = 0.00;
				}

				$this->viewdata['restaurant'] = $restaurant;
				$this->viewdata['schedules'] = RestaurantSchedule::where('restaurant_id','=',$restaurant->id)->get();
				$this->viewdata['menus'] = Menus::all($restaurant->id);
				$this->viewdata['items'] = Menus::allItems($restaurant->id, "yes");
				$this->viewdata['status'] = Restaurants::status($restaurant->id);
				$this->viewdata['cart_contents'] = $contents;
				$this->viewdata['cart_total'] = $carttotal;
				$this->viewdata['total'] = $carttotal + $restaurant->meta->delivery_fee;
				//render view
				$this->layout->content = View::make($this->viewpath('frontend.restaurant.index'), $this->viewdata);
			}
			elseif(!$slug || !$restaurant)
			{
				App::abort(404, 'Page not found');
			}
		}
	}
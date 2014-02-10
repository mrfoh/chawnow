<?php
	class SearchController extends BaseController
	{
		public function __construct() 
		{
			parent::__construct();
			$this->layout = $this->setLayout('master');
		}

		private function getResults($models)
		{
			$data = array();
			if($models)
			{
				foreach($models as $model)
				{
					$data[] = ($model->restaurant_id) ? $model->restaurant_id : $model->id;
				}

				return $data;
			}
			else
			{
				return array();
			}
		}

		private function search($params, $perPage) 
		{

			if(!is_null($params['cuisines']))
			{
				//search restaurnt cuisine table
				if(is_array($params['cuisines'])) {
					$results = RestaurantCuisine::whereIn('cuisine_id',$params['cuisines'])->get();
				}
				else {
					$results = RestaurantCuisine::where('cuisine_id', '=', $params['cuisines'])->get();
				}

				$matches['cuisines'] = $this->getResults($results);
			}
			else
				$matches['cuisines'] = array();

			if(!is_null($params['deliveries']))
			{
				//search by restaurants that offer deliveries
				$results = RestaurantMeta::where('deliveries','=',1)->get();
				$matches['deliveries'] = $this->getResults($results);
			}
			else
				$matches['deliveries'] = array();

			if(!is_null($params['pickups']))
			{
				//search by restaurants that offer pickups
				$results = RestaurantMeta::where('pickups','=',1)->get();
				$matches['pickups'] = $this->getResults($results);
			}
			else
				$matches['pickups'] = array();

			$ids = array_merge($matches['cuisines'], $matches['deliveries'], $matches['pickups']);
			$ids = array_unique($ids);

			if($ids)
			{
				if(!is_null($params['area']) && !is_string($params['area'])) {
					$results = Restaurant::with('meta')
										 ->whereIn('id', $ids)
										 ->where('area_id','=',$params['area'])
									     ->where('active','=',1)
										 ->paginate($perPage);
				}
				else {
					$results = Restaurant::with('meta')
										 ->whereIn('id', $ids)
									     ->where('active','=',1)
										 ->paginate($perPage);
				}
			}
			else
			{
				$results = Restaurant::with('meta')
										 ->where('area_id','=',$params['area'])
									     ->where('active','=',1)
										 ->paginate($perPage);
			}
			
			return $results;
		}

		public function lookUp() 
		{
			//get search paramemters
			$area = Input::get('area',NULL);
			$cuisines = Input::get('cuisine', NULL);
			$deliveries = Input::get('deliveries', NULL);
			$pickups = Input::get('pickups', NULL);

			//results per page
			$perPage = 20;

			//get area and city data
			$location = Area::with('city')->find($area);
			
			//find restaurants
			$results = $this->search(array(
				"area"=>$area,
				"cuisines"=>$cuisines,
				"deliveries"=>$deliveries,
				"pickups"=>$pickups
			), $perPage);

			//view data
			$this->viewdata['results'] = $results;
			$this->viewdata['area'] = $area;
			$this->viewdata['location'] = $location;
			$this->viewdata['params'] = array("area"=>$area, "cuisines"=>$cuisines, "deliveries"=>$deliveries, "pickups"=>$pickups);
			//render view
			$this->layout->content = View::make($this->viewpath('frontend.search.results'), $this->viewdata);
		}
	}
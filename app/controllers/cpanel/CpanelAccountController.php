<?php
	
	class CpanelAccountController extends CpanelController
	{
		private $itemValidateRules = array(
			"name" => "required",
			"minimuim_order" => "required",
			"address" => "required"
		);

		private function getLocales()
		{
			$locales = array();
			$cities = City::with('areas')->get();

			foreach($cities as $city)
			{
				$data['id'] = $city->id;
				$data['name'] = $city->name; 
				$data['areas'] = array();
				
				foreach ($city->areas as $area)
				{
					$dat['id'] = $area->id;
					$dat['name'] = $area->name;
					$data['areas'][] = $dat;
				}

				$locales[] = $data;
			}

			return $locales;
		}

		private function slugify($text)
		{ 
		  // replace non letter or digits by -
		  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		  // trim
		  $text = trim($text, '-');

		  // transliterate
		  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		  // lowercase
		  $text = strtolower($text);

		  // remove unwanted characters
		  $text = preg_replace('~[^-\w]+~', '', $text);

		  if (empty($text))
		  {
		    return 'n-a';
		  }

		  return $text;
		}

		private function cuisineChanges($cuisines)
		{
			$currentcuisines = array();
			$newcuisines = $cuisines;

			foreach($this->restaurant->cuisines as $cuisine)
			{
				$currentcuisines[] = $cuisine->cuisine_id;
			}

			$changes = array_diff($currentcuisines, $cuisines);

			foreach($changes as $change)
			{
				$restaurantcuisine = RestaurantCuisine::where('restaurant_id','=', $this->restaurant->id)
													  ->where('cuisine_id', '=', $change)
													  ->first();
				if($restaurantcuisine)							  
					$restaurantcuisine->delete();
			}
		}

		public function index()
		{	
			$this->viewdata['locales'] = $this->getLocales();
			$this->viewdata['restaurant'] = $this->restaurant;
			$this->viewdata['message'] = Session::get('message');
			$this->viewdata['cuisines'] = Cuisine::all();

			$this->layout->content = View::make('cpanel.account.index', $this->viewdata);
		}

		public function update()
		{
			//get restaurant model
			$restaurant = Restaurant::find($this->restaurant->id);
			//get restaurant meta
			$meta = RestaurantMeta::where('restaurant_id', '=', $this->restaurant->id)->first();
			//form attributes
			$attributes = Input::all();
			//validation
			$validation = Validator::make($attributes, $this->itemValidateRules);
			//run validation
			if($validation->fails())
			{
				return Redirect::to('account')->withErrors($validation);
			}
			else
			{
				//Update restaurant fields
				$restaurant->name = Input::get('name');
				$restaurant->logo = Input::get('logo', $restaurant->logo);
				$restaurant->slug = $this->slugify(Input::get('name'));
				$restaurant->city_id = Input::get('city');
				$restaurant->area_id = Input::get('area');
				$restaurant->address = Input::get('address');
				$restaurant->email = Input::get('email');
				$restaurant->phone = Input::get('phone');
				$restaurant->bio = Input::get('bio');

				if($restaurant->save())
				{
					//Update restaurant meta fields
					$meta->minimium = Input::get('minimuim_order');
					$meta->pickups = Input::get('pickups', 0);
					$meta->deliveries = Input::get('deliveries', $meta->deliveries);
					$meta->pickup_time = Input::get('pickup_time', NULL);
					$meta->delivery_time = Input::get('delivery_time', NULL);
					$meta->delivery_fee = Input::get('delivery_fee', 0.0);
					$meta->order_limit = Input::get('order_limit',NULL);

					if($meta->save())
					{
						//Update cuisines
						$cuisines = Input::get('cuisine');
						foreach ($cuisines as $cuisine) 
						{
							//find existing
							$existing = RestaurantCuisine::where('restaurant_id','=',$this->restaurant->id)
														 ->where('cuisine_id','=', $cuisine)
														 ->first();
							if(!$existing)
							{
								//create new
								$restaurantcuisine = new RestaurantCuisine;

								$restaurantcuisine->restaurant_id = $this->restaurant->id;
								$restaurantcuisine->cuisine_id = $cuisine;

								$restaurantcuisine->save();
							}

							$this->cuisineChanges($cuisines);
						}

						Session::flash('message', 'Restaurant data successfully updated');
						//redirect to restaurant list
						return Redirect::to('account');
					}
				}
			}
		}
	}
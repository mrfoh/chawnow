<?php
	
	class BackendRestaurantController extends BackendController
	{
		private $newItemValidationRules = array(
			"name" => "required|unique:restaurants,name",
			"minimuim_order" => "required",
			"address" => "required"
		);

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

		/**
		* Displays the restaurants on the database
		*/
		public function index()
		{
			//flash message
			$message = Session::get('message');
			//per page
			$perPage = 20;
			//get restaurants
			$restaurants = Restaurant::with(array('meta','area','city'))
									  ->orderBy('created_at','desc')
									  ->paginate($perPage);
			//view data
			$this->viewdata['restaurants'] = $restaurants;
			$this->viewdata['message'] = $message;
			//render view
			$this->layout->content = View::make('backend.restaurants.list', $this->viewdata);
		}

		/**
		* Displays the restaurant form 
		**/
		public function form($id = null)
		{
			if(is_null($id))
			{
				$this->viewdata['action'] = "new"; 
				$this->viewdata['restaurant'] = array();
			}
			else
			{
				$this->viewdata['action'] = "edit";
				$this->viewdata['id'] = $id;
				$this->viewdata['restaurant'] = Restaurant::with(array('meta','schedules'))->find($id);
			}

			$this->viewdata['locales'] = $this->getLocales();

			$this->layout->content = View::make('backend.restaurants.form', $this->viewdata);
		}

		/**
		* Add restaurant to the database
		**/
		public function add()
		{
			//form attributes
			$attributes = Input::all();
			//validation
			$validation = Validator::make($attributes, $this->newItemValidationRules);
			//run validation
			if($validation->fails())
			{
				Input::flash();
				return Redirect::to('restaurants/add')->withErrors($validation);
			}
			else
			{
				//basic restaurant data
				$restaurant = new Restaurant;

				$restaurant->name = Input::get('name');
				$restaurant->slug = $this->slugify(Input::get('name'));
				$restaurant->logo = Input::get('logo');
				$restaurant->city_id = Input::get('city');
				$restaurant->area_id = Input::get('area');
				$restaurant->address = Input::get('address');
				$restaurant->bio = Input::get('bio');

				if($restaurant->save())
				{
					//restaurnat meta data
					$meta = new RestaurantMeta;

					$meta->restaurant_id = $restaurant->id;
					$meta->minimium = Input::get('minimuim_order');
					$meta->pickups = Input::get('pickups', 0);
					$meta->deliveries = Input::get('deliveries', 0);
					$meta->pickup_time = Input::get('pickup_time', NULL);
					$meta->delivery_time = Input::get('delivery_time', NULL);
					$meta->delivery_fee = Input::get('delivery_fee', 0.0);

					if($meta->save())
					{
						//restaurant delivery schedules
						$daysofweek = array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");
						foreach($daysofweek as $day)
						{
							$openTime = $day."_open_time";
							$closeTime = $day."_close_time";

							$schedule = new RestaurantSchedule;
							$schedule->restaurant_id = $restaurant->id;
							$schedule->day = $day;
							$schedule->open_time = Input::get($openTime);
							$schedule->close_time = Input::get($closeTime);

							$schedule->save();
						}

						return Redirect::to('restaurants');
					}
				}
			}
		}

		public function update($id)
		{
			//get restaurant model
			$restaurant = Restaurant::find($id);
			//get restaurant meta
			$meta = RestaurantMeta::where('restaurant_id', '=', $id)->first();
			//form attributes
			$attributes = Input::all();
			//validation
			$validation = Validator::make($attributes, $this->itemValidateRules);
			//run validation
			if($validation->fails())
			{
				return Redirect::to('restaurants/add')->withErrors($validation);
			}
			else
			{
				//Update restaurant fields
				$restaurant->name = Input::get('name');
				$restaurant->logo = Input::get('logo', $restaurant->logo);
				$restaurant->city_id = Input::get('city');
				$restaurant->area_id = Input::get('area');
				$restaurant->address = Input::get('address');
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

					if($meta->save())
					{
						Session::flash('message', 'Restaurant data successfully updated');
						//redirect to restaurant list
						return Redirect::to('restaurants');
					}
				}
			}
		}

		public function delete($id)
		{
			$restaurant = Restaurant::find($id);

			$restaurant->delete();

			Session::flash('message', 'Restaurant successfully removed from database');
			return Redirect::to('restaurants');
		}

		public function activate($id)
		{
			$restaurant = Restaurant::find($id);
			$restaurant->active = 1;

			$restaurant->save();

			Session::flash('message', $restaurant->name.' has been activated');
			return Redirect::to('restaurants');
		}

		public function deactivate($id)
		{
			$restaurant = Restaurant::find($id);
			$restaurant->active = 0;

			$restaurant->save();

			Session::flash('message', $restaurant->name.' has been deactivated');
			return Redirect::to('restaurants');
		}

		public function hours($id)
		{
			//get restaurant
			$restaurant = Restaurant::with('schedules')->find($id);
			//viewdata
			$this->viewdata['id'] = $id;
			$this->viewdata['restaurant'] = $restaurant;
			//render view
			$this->layout->content = View::make('backend.restaurants.hours', $this->viewdata);
		}

		public function updateHours($id)
		{
			$daysofweek = array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");

			foreach($daysofweek as $day)
			{
				//find schedule
				$schedule = RestaurantSchedule::where('day','=', $day)->where('restaurant_id','=',$id)->first();

				$open = $day."_open_time";
				$close = $day."_close_time";

				$schedule->open_time = Input::get($open);
				$schedule->close_time = Input::get($close);

				$schedule->save();
			}

			Session::flash('message', 'Restaurant delivery and pickups hours updated');
			return Redirect::to('restaurants');
		}

		public function staff($id)
		{
			//get restaurant
			$restaurant = Restaurant::with(array('staff','staff.user'))->find($id);

			$group = Sentry::findGroupByName('Restaurant Staff');
			$groupmembers = Sentry::findAllUsersInGroup($group);

			foreach ($groupmembers as $user) 
			{
				$users[] = $user->first_name." ".$user->last_name;
			}
			//viewdata
			$this->viewdata['restaurant'] = $restaurant;
			$this->viewdata['users'] = $users;
			$this->viewdata['id'] = $id;
			//render view
			$this->layout->content = View::make('backend.restaurants.staff', $this->viewdata);
		}

		public function addStaff($id)
		{
			$name = explode(" ", Input::get('name'));

			$user = User::where('first_name','=',$name[0])->where('last_name','=',$name[1])->first();

			$existing = RestaurantStaff::where('restaurant_id','=',$id)->where('user_id','=', $user->id)->first();
			if($existing)
			{
				return Response::json(array("status"=>"error","message"=>"User is already on the restaurants staff list"));
			}
			else
			{
				$staff = new RestaurantStaff;
				
				$staff->restaurant_id = $id;
				$staff->user_id = $user->id;

				if($staff->save())
				{
					$newstaff = RestaurantStaff::with('user')->find($staff->id);
					return Response::json(array("status"=>"success","model" => $newstaff->toArray()), 200);
				}
			}
		}

		public function removeStaff($id, $staffid)
		{
			$staff = RestaurantStaff::where('restaurant_id', '=', $id)
									->where('id','=',$staffid)
									->first();

			if($staff)
			{
				//delete record
				$staff->delete();
				//return response
				return Response::json(array("status"=>"success","message"=>"User successfully removed."));
			}
		}
	}
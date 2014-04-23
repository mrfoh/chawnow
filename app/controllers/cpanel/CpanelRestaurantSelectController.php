<?php
	
	class CpanelRestaurantSelectController extends Controller
	{
		public function index()
		{
			//get user
			$user = Sentry::getUser();

			if($user)
			{
				//get all user restaurants
				$restaurants = RestaurantStaff::with('restaurant')->where('user_id','=', $user->id)->get();

				//pass data to view
				$data['restaurants'] = $restaurants;
				$data['user'] = $user;

				//render view
				return View::make('cpanel.restaurantSelect', $data);
			}
			else
			{
				return Redirect::to('login');
			}
		}

		public function select($id)
		{	
			//set restaurant in session
			Session::put('restaurant', $id);
			//redirect to dashboard
			return Redirect::to('/');
		}
	}
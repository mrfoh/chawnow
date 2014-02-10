<?php
	
	class Restaurants
	{
		/**
		* Find restaurant by a staff user id
		* @access public
		* @param integer $userid
		* user_id of staff
		* @return object
		* Restaurant Object
		**/
		public static function findByStaffId($userid)
		{
			//get restaurant by staff id
			$relationships = array("restaurant","restaurant.meta","restaurant.cuisines","restaurant.area","restaurant.city");
			$employer = RestaurantStaff::with($relationships)
									   ->where('user_id','=', $userid)
									   ->first();

			if($employer)
				return $employer->restaurant;
			else
				return false;
		}

		/**
		* Find restaurant by name
		* @access public
		* @param string $name
		* name of restuarant
		* @return object
		* Restaurant Object
		**/
		public static function findByName($name)
		{
			//get restaurant by name
			$restaurant = Restaurant::with('meta')->where('name','=',$name)->first();

			if($restaurant)
				return $restaurant;
			else
				return false;
		}

		public static function findBySlug($slug)
		{
			//get restaurant by slug
			$restaurant = Restaurant::with('meta')->where('slug','=',$slug)->first();

			if($restaurant)
				return $restaurant;
			else
				return false;
		}
		/**
		* Determines if a restaurants status
		* @return boolean
		* TRUE if restaurant is open
		* FALSE if restaurant is closed
		**/
		public static function status($restaurantid)
		{
			//current day
			$currentday = date("D", time());
			//current time
			$currenttime = date("h:i A", time());
			//days of the week
			$days= array(
				"Sun"  => "sunday",
				"Mon"  => "monday",
				"Tue"  => "tuesday",
				"Wed"  => "wednesday",
				"Thu" => "thursday", 
				"Fri"  => "friday",
				"Sat"  => "saturday"
			);
			//get restaurant schedule for current day
			$schedule = RestaurantSchedule::where('restaurant_id','=',$restaurantid)
										  ->where('day', '=', $days[$currentday])
										  ->first();
			//opening time (unix)
			$openTime = strtotime($schedule->open_time);
			//closing time (unix)
			$closeTime = strtotime($schedule->close_time);
			//current time (unix)
			$curtime = strtotime($currenttime);

			//restaurant open
			if($curtime >= $openTime && $curtime <= $closeTime)
				return true;
			//restaurant closed
			else
				return false;							  
		}
	}
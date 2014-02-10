<?php
	class Restaurant extends Eloquent
	{
		protected $fillable = array("name","slug","logo","city_id","area_id","address","bio");

		public function meta()
		{
			return $this->hasOne('RestaurantMeta');
		}

		public function cuisines()
		{
			return $this->hasMany('RestaurantCuisine');
		}

		public function menu()
		{
			return $this->hasOne('menu');
		}

		public function staff()
		{
			return $this->hasMany('RestaurantStaff', 'restaurant_id');
		}

		public function area()
		{
			return $this->belongsTo('Area');
		}

		public function city()
		{
			return $this->belongsTo('City');
		}

		public function schedules()
		{
			return $this->hasMany('RestaurantSchedule');
		}

		public function orders()
		{
			return $this->hasMany('Order');
		}

		public function delete()
		{
			//delete meta
			$this->meta->delete();
			//delete schedules
			foreach($this->schedules as $schedule) {
				$schedule->delete();
			}
			//delete cuisines
			foreach($this->cuisines as $cuisine) {
				$cuisine->delete();
			}
			return parent::delete();
		}
	}
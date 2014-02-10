<?php
	
	class RestaurantSchedule extends Eloquent
	{

		protected $table = 'restuarant_schedules';

		public function restaurant()
		{
			return $this->belongsTo('Restaurant');
		}
	}
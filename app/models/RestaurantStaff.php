<?php
	class RestaurantStaff extends Eloquent
	{
		protected $table = 'restaurant_staff';
		protected $fillable = array('restuarant_id', 'user_id');

		public function restaurant()
		{
			return $this->belongsTo('Restaurant');
		}

		public function user()
		{
			return $this->belongsTo('User');
		}
	}
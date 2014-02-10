<?php
	class RestaurantCuisine extends Eloquent
	{
		protected $table = 'restaurant_cuisines';
		protected $fillable = array("restaurant_id","cuisine_id");

		public function cuisine()
		{
			return $this->hasOne('Cuisine');
		}
	}
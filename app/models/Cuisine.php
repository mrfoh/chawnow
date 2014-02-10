<?php
	class Cuisine extends Eloquent
	{
		protected $fillable = array("name","slug");

		public function restaurants()
		{
			return $this->hasMany('RestaurantCuisine');
		}
	}
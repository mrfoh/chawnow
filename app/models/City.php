<?php
	
	class City extends Eloquent
	{

		protected $fillable = array("name","slug");

		public function areas()
		{
			return $this->hasMany('Area');
		}

		public function restaurants()
		{
			return $this->hasMany('Restaurants');
		}
	}
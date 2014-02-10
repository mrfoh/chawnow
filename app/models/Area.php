<?php
	
	class Area extends Eloquent
	{
		protected $fillable = array("city_id","name","slug","active");

		public function city()
		{
			return $this->belongsTo('City');
		}

		public function restaurants()
		{
			return $this->hasMany('Restaurant');
		}
	}
<?php
	class Menu extends Eloquent
	{
		protected $fillable = array('name','restaurant_id','active');

		public function restaurant()
		{
			return $this->belongsTo('Restaurant');
		}

		public function categories()
		{
			return $this->hasMany('MenuCategory');
		}

		public function items()
		{
			return $this->hasMany('Item');
		}
	}
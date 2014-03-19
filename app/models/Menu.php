<?php
	class Menu extends Eloquent
	{
		protected $fillable = array('name','slug','restaurant_id','active');

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

		protected static function boot() {
		
	        parent::boot();

	        static::deleting(function($menu) { // before delete() method call this
	             $menu->items()->delete();
	             $menu->categories()->delete();
	             // do the rest of the cleanup...
	        });
    	}
	}
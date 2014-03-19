<?php
	class MenuCategory extends Eloquent
	{
		protected $table = 'menu_categories';

		protected $fillable = array('menu_id','name');

		public function items()
		{
			return $this->hasMany('Item','menu_category_id');
		}

		public function groups()
		{
			return $this->hasMany('ItemGroup', 'menu_category_id');
		}

		protected static function boot()
		{
			parent::boot();

	        static::deleting(function($category) { // before delete() method call this
	             $category->groups()->delete();
	             // do the rest of the cleanup...
	    	});
		}
	}
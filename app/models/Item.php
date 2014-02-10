<?php
	class Item extends Eloquent
	{
		protected $fillable = array("restaurant_id", "menu_id", "menu_category_id", "item_group_id", "name", "price", "active");

		public function group()
		{
			return $this->belongsTo('ItemGroup','item_group_id');
		}

		public function category()
		{
			return $this->belongsTo('MenuCategory','menu_category_id');
		}

		public function restaurant()
		{
			return $this->belongsTo('Restaurant');
		}

		public function menu()
		{
			return $this->belongsTo('Menu');
		}
	}
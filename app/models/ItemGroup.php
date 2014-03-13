<?php
	class ItemGroup extends Eloquent
	{
		protected $fillable = array("menu_category_id", "name");

		public function items()
		{
			return $this->hasMany('Item','item_group_id');
		}
	}
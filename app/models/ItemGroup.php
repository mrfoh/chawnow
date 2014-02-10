<?php
	class ItemGroup extends Eloquent
	{
		protected $fillable = array("name");

		public function items()
		{
			return $this->hasMany('Item','item_group_id');
		}
	}
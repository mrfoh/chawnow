<?php
	
	class ItemOptionValue extends Eloquent
	{
		protected $table = 'item_option_values';

		protected $fiilable = array("option_id", "value", "price");

		public function option()
		{
			return $this->belongsTo('ItemOption', 'option_id');
		}
	}
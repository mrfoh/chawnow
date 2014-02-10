<?php
	
	class OrderItem extends Eloquent
	{
		protected $table = 'order_items';

		protected $fillable = array("order_id","item_id","qty");

		public function order()
		{
			return $this->belongsTo('Order');
		}

		public function item()
		{
			return $this->belongsTo('Item');
		}
	}
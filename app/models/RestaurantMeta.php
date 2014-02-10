<?php
	class RestaurantMeta extends Eloquent
	{
		protected $table = 'restaurant_meta';
		protected $fillable = array("restuarant_id","minimium","pickups","deliveries","pickup_time","delivery_fee","delivery_time","order_limit");

		public function restaurant()
		{
			return $this->belongsTo('Restaurant');
		}
	}
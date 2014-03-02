<?php
	
	class Order extends Eloquent
	{
		protected $fillable = array(
			"restaurant_id",
			"user_id",
			"type",
			"guest",
			"customer_name",
			"customer_email",
			"customer_address",
			"customer_phone",
			"comments",
			"status",
			"verification_code"
		);

		public function next()
		{
			return static::where('id', '>', $this->id)->first();
		}

		public function previous()
		{
			return static::where('id', '<', $this->id)->first();
		}
		
		public function items() {

			return $this->hasMany('OrderItem');
		}

		public function restaurant() {

			return $this->belongsTo('Restaurant');
		}
	}
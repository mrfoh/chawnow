<?php

	class Address extends Eloquent
	{
		protected $fillable = array("user_id","name","text");

		public function user()
		{
			return $this->belongsTo('User');
		}
	}
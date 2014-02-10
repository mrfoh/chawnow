<?php
	class Profile extends Eloquent
	{
		protected $fillable = array("user_id","uid","mobile_no","access_token","access_token_secret");

		public function user()
		{
			return $this->belongsTo('User');
		}
	}
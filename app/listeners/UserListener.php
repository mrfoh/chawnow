<?php
	
	class UserListener
	{	
		/**
		* Sends a newly registered user a welcome email
		**/
		public function registered($email)
		{
			//send email
			Log::info('Send welcome email');
		}
	}
<?php
	
	class Group extends Eloquent
	{
		public function users() 
		{
			return $this->belongsToMany('User','users_groups');
		}
	}
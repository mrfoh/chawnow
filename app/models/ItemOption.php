<?php
	
	class ItemOption extends ELoquent
	{

		protected $table = 'item_options';

		protected $fillable = array("item_id","name","required");

		public function item()
		{
			return $this->belongsTo('Item');
		}

		public function values()
		{
			return $this->hasMany('ItemOptionValue', 'option_id');
		}

		protected static function boot() {
	        parent::boot();

	        static::deleting(function($option) { // before delete() method call this
	            $option->values()->delete();
	             // do the rest of the cleanup...
	        });
	    }
	}
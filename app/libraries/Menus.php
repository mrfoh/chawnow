<?php
	
	class Menus
	{
		private static function slugify($text)
		{ 
		  // replace non letter or digits by -
		  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		  // trim
		  $text = trim($text, '-');

		  // transliterate
		  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		  // lowercase
		  $text = strtolower($text);

		  // remove unwanted characters
		  $text = preg_replace('~[^-\w]+~', '', $text);

		  if (empty($text))
		  {
		    return 'n-a';
		  }

		  return $text;
		}

		private static function formatMenuArray($menu)
		{
			$data = array();

			$data['id'] = $menu->id;
			$data['restaurant_id'] = $menu->restaurant_id;
			$data['name'] = $menu->name;
			$data['slug'] = $menu->slug;
			$data['items'] = $menu->items->toArray();
			$data['categories'] = $menu->categories->toArray();
			$data['active'] = (bool) $menu->active;
			$data['created_at'] = date('c', strtotime($menu->created_at));

			return $data;
		}

		private static function formatItemArray($item)
		{
			$data['id'] = $item->id;
			$data['menu_name'] = $item->menu->name;
			$data['name'] = $item->name;
			$data['description'] = $item->description;
			$data['price'] = $item->price;
			$data['active'] = (bool) $item->active;
			$data['category'] = ($item->category) ? $item->category->toArray() : NULL;
			$data['group'] = ($item->group) ? $item->group->toArray() : NULL;
			$data['options'] = ($item->options) ? $item->options->toArray() : NULL;
			$data['menu'] = $item->menu->toArray();
			$data['created_at'] = date('c', strtotime($item->created_at));

			return $data;
		}

		/**
		* Retrieves all restaurants menu
		* @access public
		* @param integer $id
		* Restaurant's id
		* @param string $active
		* Yes = Active, No = Inactive, All = All
		* @return array
		* Menus
		**/
		public static function all($id, $active = "yes")
		{
			$restaurantmenus = array();
			$relationships = array(
				"items",
				"items.options",
				"items.options.values",
				"categories",
				"categories.items",
				"categories.items.options",
				"categories.items.options.values",
				"categories.groups",
				"categories.groups.items",
				"categories.groups.item.options",
				"categories.groups.item.options.values");

			//Active menus
			if($active == "yes")
			{
				$menus = Menu::with($relationships)
							  ->where('restaurant_id','=',$id)
							  ->where('active','=',1)
							  ->orderBy('created_at','desc')
							  ->get();
			}
			//Inactive menus
			elseif($active == "no")
			{
				$menus = Menu::with($relationships)
							  ->where('restaurant_id','=',$id)
							  ->where('active','=',0)
							  ->orderBy('created_at','desc')
							  ->get();
			}
			//All menus
			elseif ($active == "all")
			{
				$menus = Menu::with($relationships)
							  ->where('restaurant_id','=',$id)
							  ->orderBy('created_at','desc')
							  ->get();	
			}

			if($menus)
			{
				foreach($menus as $menu)
				{
					$restaurantmenus[] = self::formatMenuArray($menu);
				}

				return $restaurantmenus;
			}
			else {

				return $restaurantmenus;
			}
		}


		/**
		* Retrieves all a restaurants menu items
		* @access public
		* @param integer $id
		* ID of the restaurant
		* @return array
		*/
		public static function allItems($id, $active = "all") {

			$items = array();
			$relationships = array('category','menu','options','options.values');

			if($active == "all")
			{
				$restaurantItems = Item::with($relationships)
									->where('restaurant_id','=', $id)
									->orderBy('created_at','asc')
									->get();	
			}
			elseif($active = "yes")
			{
				$restaurantItems = Item::with($relationships)
									->where('restaurant_id','=', $id)
									->where('active','=',1)
									->orderBy('created_at','asc')
									->get();
			}
			elseif($active = "no")
			{
				$restaurantItems = Item::with($relationships)
									->where('restaurant_id','=', $id)
									->where('active','=',0)
									->orderBy('created_at','asc')
									->get();
			}
			
			if($restaurantItems)
			{
				foreach($restaurantItems as $item) 
				{
					$items[] = self::formatItemArray($item);
				}
			}

			return $items;
		}

		public static function getItem($id)
		{
			$relationships = array('category','group','options','options.values');
			$model = Item::with($relationships)->find($id);

			return $model;
		}

		/**
		* Create a new menu item
		* @access public
		* @param array $params
		* @return array $item
		* Item array
		**/
		public static function createItem($params) {

			$item = new Item;

			foreach($params as $key => $param)
			{
				$item->$key = $param;
			}

			if($item->save()) {
				return $item->id;
			}
		}

		public static function addItemOptions($options, $id)
		{
			if($options && is_array($options))
			{
				self::clearItemOptions($id);

				foreach($options as $option)
				{
					$decoded = json_decode($option);

					$itemOption = new itemOption;
					$itemOption->item_id = $id;
					$itemOption->name = $decoded->name;
					$itemOption->required = (int) $decoded->required;

					$itemOption->save();

					foreach($decoded->values as $valueobj)
					{
						$itemOptionValue = new itemOptionValue;

						$itemOptionValue->option_id = $itemOption->id;
						$itemOptionValue->value = $valueobj->value;
						$itemOptionValue->price = $valueobj->price;

						$itemOptionValue->save();
					}
				}

				return true;
			}
		}

		/**
		* Updates a menu item
		* @access public
		* @param array $params
		* @param integer $id
		* Item Id
		* @return array $item
		**/
		public static function updateItem($params, $id) {

			$item = Item::find($id);
			
			foreach($params as $key => $param)
			{
				$item->$key = $param;
			}

			if($item->save()) {
				return true;
			}
		}

		private static function clearItemOptions($id)
		{
			$item = self::getItem($id);
			
			foreach($item->options as $option) {
				$option->delete();
			}

			return true;
		}

		/**
		* Deletes a menu item
		* @access public
		* @param integer $id
		* Item ID
		* @return boolean
		**/
		public static function deleteItem($id) {
			$item = Item::find($id);
			if($item)
			{
				$item->delete();

				return true;
			}
			else
			{
				return false;
			}
		}

		public static function activateItem($id) {

			$item = Item::find($id);

			$item->active = 1;

			if($item->save()) 
				return true;
			else 
				return false;
		}

		public static function deactivateItem($id) {
			
			$item = Item::find($id);

			$item->active = 0;

			if($item->save()) 
				return true;
			else 
				return false;
		}

		/**
		* Creates a menu
		* @access public
		* @param integer $id
		* Restaurant id
		* @param string $name
		* Menu name
		* @param integer $active
		* 1 - Active
		* 0 - Inactive
		* @return array $menu
		*/
		public static function create($id, $name, $active) {

			$menu = new Menu;

			$menu->name = $name;
			$menu->slug = self::slugify($name);
			$menu->restaurant_id = $id;
			$menu->active = $active;

			if($menu->save())
			{
				return self::formatMenuArray($menu);
			}
		}

		/**
		* Updates a menu
		* @access public
		* @param integer $id
		* menu id
		* @param string $name
		* Menu name
		* @return array $menu
		*/
		public static function update($id, $name) {

			$menu = Menu::find($id);

			if($menu)
			{
				$menu->name = $name;
				$menu->slug = self::slugify($name);

				if($menu->save())
					return self::formatMenuArray($menu);
			}
		}

		/**
		* Deletes a menu
		* @access public
		* @param integer $id
		* menu id
		* @return boolean
		*/
		public static function delete($id) {

			$menu = Menu::find($id);
			if($menu)
			{
				$menu->delete();

				return true;
			}
			else
			{
				return false;
			}
		}

		public static function activateMenu($id) {

			$menu = Menu::find($id);

			$menu->active = 1;

			if($menu->save()) 
				return true;
			else 
				return false;
		}

		public static function deactivateMenu($id) {
			
			$menu = Menu::find($id);

			$menu->active = 0;

			if($menu->save()) 
				return true;
			else 
				return false;
		}
	}
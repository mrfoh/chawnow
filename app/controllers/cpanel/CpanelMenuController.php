<?php
	
	class CpanelMenuController extends CpanelController
	{
		public function index()
		{
			$this->viewdata['menus'] = Menus::all($this->restaurant->id, "all");
			$this->viewdata['menu_items'] = Menus::allItems($this->restaurant->id);

			$this->layout->content = View::make('cpanel.menus.index', $this->viewdata);
		}

		public function addMenu()
		{
			$name = Input::get('name');
			$id = Input::get('restaurant_id');
			$active = Input::get('active');

			$menu = Menus::create($id, $name, $active);

			if($menu)
				return Response::json($menu,200);
		}

		public function updateMenu($id)
		{
			$menu = Menus::update($id, Input::get('name'));
			if($menu)
				return Response::json($menu, 200); 
		}

		public function deleteMenu($id)
		{
			$menu = Menus::delete($id);
			if($menu)
				return Response::json(array("status"=>"success"), 200);	
		}

		public function activateMenu($id) 
		{
			$activate = Menus::activateMenu($id);

			if($activate)
				return Response::json(array("status"=>"success", "message" => "Menu activated"));
		}

		public function deactivateMenu($id)
		{
			$deactivate = Menus::deactivateMenu($id);

			if($deactivate)
				return Response::json(array("status"=>"success", "message" => "Menu deactivated"));
		}

		public function addCategory()
		{
			$name = Input::get('name');
			$menu = Input::get('menu');

			$category = new MenuCategory;

			$category->menu_id = $menu;
			$category->name = $name;

			if($category->save())
			{
				return Response::json( array('status'=>"success", "model"=> $category->toArray()) );
			}
		}

		public function addItem()
		{
			//get item data
			$params['name'] = Input::get('name');
			$params['restaurant_id'] = Input::get('restaurant_id');
			$params['price'] = Input::get('price');
			$params['menu_id'] = Input::get('menu_id');
			$params['menu_category_id'] = Input::get('menu_category_id', NULL); 
			$params['active'] = Input::get('active');

			//create item
			$item = Menus::createItem($params);

			if($item)
				return Response::json($item, 200);
		}

		public function updateItem($id)
		{
			//get item data
			$params['name'] = Input::get('name');
			$params['price'] = Input::get('price');
			$params['menu_id'] = Input::get('menu_id');
			$params['menu_category_id'] = Input::get('menu_category_id', NULL); 
			$params['active'] = Input::get('active');

			//create item
			$item = Menus::updateItem($params, $id);

			if($item)
				return Response::json($item, 200);
		}

		public function removeItem($id)
		{
			$item = Menus::deleteItem($id);
			if($item)
				return Response::json(array("status"=>"success"), 200);	
		}

		public function activateItem($id)
		{
			$activate = Menus::activateItem($id);

			if($activate)
				return Response::json(array("status"=>"success", "message" => "Item activated"));
		}

		public function deactivateItem($id)
		{
			$deactivate = Menus::deactivateItem($id);

			if($deactivate)
				return Response::json(array("status"=>"success", "message" => "Item deactivated"));
		}
	}
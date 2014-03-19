<?php
	
	class CpanelMenuController extends CpanelController
	{
		/**
		* Displays menus page
		*/
		public function index()
		{
			$_items = Menus::allItems($this->restaurant->id);
			$items = Paginator::make($_items, count($_items), 10);

			$this->viewdata['menus'] = Menus::all($this->restaurant->id, "all");
			$this->viewdata['items'] = $items;
			$this->viewdata['message'] = Session::get('message');

			$this->layout->content = View::make('cpanel.menus.index', $this->viewdata);
		}

		/**
		* Adds a new menu
		*/
		public function addMenu()
		{
			$name = Input::get('name');
			$id = Input::get('restaurant_id');
			$active = Input::get('active');

			$menu = Menus::create($id, $name, $active);

			if($menu)
				return Response::json($menu,200);
		}

		/**
		* Updates a menu
		*/
		public function updateMenu($id)
		{
			$menu = Menus::update($id, Input::get('name'));
			if($menu)
				return Response::json($menu, 200); 
		}


		/**
		* Deletes a menu
		*/
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


		/*-------------------------------------------------------------------/*
		* Menu Item methods
		*--------------------------------------------------------------------*/

		public function itemForm($id = NULL)
		{
			$this->viewdata['menus'] = Menus::all($this->restaurant->id, "all");

			if(is_null($id))
			{
				$this->viewdata['action'] = "create";
				$this->viewdata['item'] = array();

				$this->layout->content = View::make('cpanel.menus.form', $this->viewdata);
			}
			else
			{
				$this->viewdata['action'] = "edit";
				$this->viewdata['id'] = $id;

				$item = Menus::getItem($id);

				if($item) {

					$this->viewdata['item'] = $item;
					$this->layout->content = View::make('cpanel.menus.form', $this->viewdata);	
				}
				else {
					App::abort(404);
				}
			}
		}

		public function addItem()
		{
			$params = array(
				'restaurant_id' => $this->restaurant->id,
				'name' => Input::get('name'),
				'price' => Input::get('price'),
				'menu_id' => Input::get('menu_id'),
				'menu_category_id' => Input::get('menu_category_id'),
				'item_group_id' => Input::get('item_group_id'),
				'description' => Input::get('description'),
				'active' => Input::get('active'),
			);

			$create = Menus::createItem($params);

			if($create)
			{
				$options = Input::get('option');
				//add options
				if($options)
					Menus::addItemOptions($options, $create);

				return Redirect::to('menus');
			}
		}

		public function updateItem($id)
		{
			$params = array(
				'name' => Input::get('name'),
				'price' => Input::get('price'),
				'menu_id' => Input::get('menu_id'),
				'menu_category_id' => Input::get('menu_category_id'),
				'item_group_id' => Input::get('item_group_id'),
				'description' => Input::get('description'),
				'active' => Input::get('active'),
			);

			$update = Menus::updateItem($params, $id);

			if($update)
			{
				$options = Input::get('option');
				//add options
				if($options)
					Menus::addItemOptions($options, $id);
				
				return Redirect::to('menus');
			}
		}
		
		public function removeItem($id)
		{
			$item = Menus::deleteItem($id);
			if($item) { 
				Session::flash('message', 'Item successfully deleted.');
				return Redirect::to('menus');
				//return Response::json(array("status"=>"success"), 200);	
			}
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

		public function addGroup()
		{
			$name = Input::get('name');
			$category =Input::get('category');

			$group = new ItemGroup;

			$group->name = $name;
			$group->menu_category_id = $category;

			if($group->save())
			{
				return Response::json( array('status' =>"success", "model" => $group->toArray()) );
			}
		}
	}
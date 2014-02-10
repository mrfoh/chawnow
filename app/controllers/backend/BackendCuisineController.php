<?php
	
	class BackendCuisineController extends BackendController
	{
		public function index()
		{
			$this->viewdata['cuisines'] = Cuisine::all()->toArray();
			//rende view
			$this->layout->content = View::make('backend.restaurants.cuisines', $this->viewdata);
		}

		public function add()
		{
			//form attributes
			$attributes = Input::all();
			//validation rules
			$rules = array(
				"name" => "required|unique:cuisines,name",
				"slug" => "required"
			);
			//validation messages
			$messages = array(
				"name.required" => "Please enter a name",
				"name.unique" => "A cuisine with this name already exists"
			);
			//validation
			$validation = Validator::make($attributes, $rules, $messages);
			//run validation
			if($validation->fails()) {

			}
			else
			{
				$cuisine = new Cuisine;

				$cuisine->name = Input::get('name');
				$cuisine->slug = Input::get('slug');

				if($cuisine->save())
				{
					return Response::json(array("status"=>"success","model"=>$cuisine->toArray()), 200);
				}
			}
		}

		public function remove($id)
		{
			$cuisine = Cuisine::find($id);
			if($cuisine)
			{
				$cuisine->delete();
				return Response::json(array("status" => "success", "message" => "Cuisine successfully removed."));
			}
		}
	}
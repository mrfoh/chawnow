<?php
	
	class AccountController extends BaseController
	{
		public function __construct() 
		{
			parent::__construct();
			$this->beforeFilter('auth');
			$this->layout = $this->setLayout('master');
		}

		/**
		* Display account page
		**/
		public function index()
		{
			//view data
			$this->viewdata['message'] = Session::get('message');
			$this->viewdata['user'] = $this->user;
			$this->viewdata['profile'] = $this->profile;
			//render view
			$this->layout->content = View::make($this->viewpath('frontend.account.index'), $this->viewdata);
		}

		/**
		* Update user account information
		**/
		public function update()
		{
			$formattributes = Input::all();

			$validationRules = array(
				'first_name' => 'required',
				'last_name' => 'required',
				'email' => 'required|email',
				'mobile_no' => 'required|numeric'
			);

			$validationMessages = array(
				'first_name.required' => "Please enter your first name",
				'last_name.required' => "Please enter your last name",
				'email.required' => "Please enter your email address",
				'email.email' => "Please enter a valid email address",
				'mobile_no.numeric' => "Please enter a valid mobile number"
			);

			$validation = Validator::make($formattributes, $validationRules, $validationMessages);

			if(!$validation->fails())
			{
				//Update user
				$this->user->first_name = Input::get('first_name');
				$this->user->last_name = Input::get('last_name');
				$this->user->email = Input::get('email');

				if($this->user->save())
				{
					//update user profile
					$this->profile->mobile_no = Input::get('mobile_no');

					if($this->profile->save())
					{
						Session::flash('message', 'Your account has successfully been updated.');
						return Redirect::to('account');
					}
				}
 			}
			else
			{
				return Redirect::to('account')->withErrors($validation);
			}
		}

		/**
		* Displays user orders
		**/
		public function orders()
		{
			//View data
			$this->viewdata['orders'] = Orders::user($this->user->id);
			//Render view
			$this->layout->content = View::make($this->viewpath('frontend.account.orders'), $this->viewdata);
		}

		/**
		* Displays user order
		**/
		public function viewOrder($id)
		{
			//View data
			$this->viewdata['order'] = Orders::get($id);
			//Render view
			$this->layout->content = View::make($this->viewpath('frontend.account.order'), $this->viewdata);
		}

		public function reorder($id)
		{
			$order = Orders::get($id);
			$restaurant = $order->restaurant->slug;
			
			//existing cart
			$existing = Session::get('activecart');
			Shpcart::cart($existing)->destroy();

			//cart items
			foreach($order->items as $orderitem)
			{
				$cartitems[] = array(
					"id"=> $orderitem->item->id,
					"qty"=> $orderitem->qty,
					"name"=> $orderitem->item->name,
					"price"=> $orderitem->item->price
				);
			}

			if($existing)
			{
				if($existing == $restaurant)
				{
					Shpcart::cart($restaurant)->insert($cartitems);
				}
				else
				{
					Shpcart::cart($existing)->destroy();
					Session::put('activecart', $restaurant);

					Shpcart::cart($restaurant)->insert($cartitems);
				}
			}
			else
			{
				Session::put('activecart', $restaurant);

				Shpcart::cart($restaurant)->insert($cartitems);	
			}

			return Redirect::to('checkout/'.$restaurant);
		}

		/**
		* Display user addresses
		**/
		public function addresses()
		{
			//user addresses
			$useraddresses = Address::where('user_id','=', $this->user->id)->orderBy('created_at','desc')->get();
			//view data
			$this->viewdata['addresses'] = $useraddresses;
			//render view
			$this->layout->content = View::make($this->viewpath('frontend.account.addresses'), $this->viewdata);
		}

		/**
		* Add user address
		**/
		public function addAddress()
		{
			$name = Input::get('name') ? Input::get('name') : "Unnamed Address";
			$text = Input::get('text');

			$address = new Address;

			$address->user_id = $this->user->id;
			$address->name = $name;
			$address->text = $text;

			if($address->save())
			{
				return Response::json(array('status'=>"success",'model'=>$address->toArray()));
			}
		}

		/**
		* Delete user addresses
		**/
		public function deleteAddress($id)
		{
			$address = Address::find($id);

			$address->delete();

			return Response::json(array('status'=>'success'));
		}

		public function password()
		{
			$this->viewdata['message'] = Session::get('message');
			//render view
			$this->layout->content = View::make($this->viewpath('frontend.account.password'), $this->viewdata);
		}

		public function changePassword()
		{
			$attributes = Input::all();

			$rules = array(
				'old' => "required",
				"newpassword" => "required",
				"confnewpassword"=> "required|same:newpassword"
			);

			$messages = array(
				'old.required' => "Please enter your old password",
				'newpassword.required' => "Please enter a password",
				'confnewpassword.required' => "Please confirm your password",
				'confnewpassword.same' => "Your passwords do match"
			);

			$validation = Validator::make($attributes, $rules, $messages);

			if(!$validation->fails())
			{
				$user = Sentry::getUser();
				//if old password is correct
				if($user->checkPassword(Input::get('old')))
				{
					$user->password = Input::get('newpassword');

					$user->save();

					Session::flash('message', 'Your password was changed successfully');
					return Redirect::to('account/password');
				}
				else
				{
					Session::flash('message', 'Your old password is incorrect');
					return Redirect::to('account/password');
				}
			}
			else
			{
				return Redirect::to('account/password')->withErrors($validation);
			}
		}
	}
<?php
	class CheckoutController extends BaseController
	{
		public function __construct() 
		{
			parent::__construct();
			$this->layout = $this->setLayout('master');
		}

		public function index($uid)
		{
			//find restaurant
			$restaurant = Restaurants::findBySlug($uid);
			$existing = Session::get('activecart');
			if($existing)
			{
				if($existing == $uid)
				{
					$contents = Shpcart::cart($existing)->contents();
					$carttotal = Shpcart::cart($existing)->total();
				}
				else
				{
					Shpcart::cart($existing)->destroy();
					$contents = array();
					$carttotal = 0.00;
				}
			}
			else 
			{
				$contents = array();
				$carttotal = 0.00;
			}
			//View data
			$this->viewdata['message'] = Session::get('message');
			$this->viewdata['uid'] = $uid;
			$this->viewdata['restaurant'] = $restaurant;
			$this->viewdata['cart_contents'] = $contents;
			$this->viewdata['cart_total'] = $carttotal;
			$this->viewdata['total'] = $carttotal + $restaurant->meta->delivery_fee;
			$this->viewdata['city'] = $restaurant->city->name;
			$this->viewdata['area'] = $restaurant->area->name;
			$this->viewdata['customer'] = $this->user;
			$this->viewdata['customer_profile'] = $this->profile;
			$this->viewdata['addressess'] = ($this->user) ? Address::where('user_id','=',$this->user->id)->get()->toArray() : array();

			//render view
			$this->layout->content = View::make($this->viewpath('frontend.checkout.index'), $this->viewdata);
		}

		public function placeOrder($uid)
		{
			$attributes = Input::all();

			$rules = array(
				"first_name"=> "required",
				"last_name"=> "required",
				"email"=> "required|email",
				"mobile_no"=> "required|numeric",
				"street"=> "required",
				"delivery_type"=> "required|in:delivery,pickup"
			);

			$messages = array(
				"first_name.required" => "Please enter your first name",
				"last_name.required" => "Please enter your first name",
				"email.required" => "Please enter your email address",
				"email.email" => "Please enter a valid email address",
				"street.required" => "Please enter your street address",
				"mobile_no.required" => "Please enter your mobile no",
				"mobile_no.numeric" => "Please enter a valid mobile no",
				"delivery_type.in" => "Please select a delivery type",
				"delivery_type.required" => "Please select a delivery type"
			);

			$validator = Validator::make($attributes, $rules, $messages);

			if(!$validator->fails())
			{
				//find restaurant
				$restaurant = Restaurants::findBySlug($uid);
				//customer data
				$customer = array(
					"customer_name"=> Input::get('first_name')." ".Input::get('last_name'),
					"customer_email"=> Input::get('email'),
					"customer_address"=> Input::get('street'),
					"customer_phone"=> Input::get('mobile_no'),
					"comments" => Input::get('comments')
				);
				//get order data
				$type = Input::get('delivery_type'); //order type
				$guest = ($this->isLoggedin) ? false : true; //is guest or customer order
				//create order
				$order = Orders::createOrder($restaurant->id, $type, $guest, $customer);
				if($order !== false)
				{
					//trigger order.placed event
					Event::fire('order.placed', array("order_id"=>$order));

					return Redirect::to('order/'.$order.'/verify');
				}
			}
			else
			{
				Input::flash();
				return Redirect::to('checkout/'.$uid)->withErrors($validator);
			}
		}

		public function verification($id)
		{
			$order = Order::with(array('restaurant','restaurant.meta'))->find($id);
			$activecart = Session::get('activecart');

			//View data
			$this->viewdata['message'] = Session::get('message');
			$this->viewdata['restaurant'] = $order->restaurant;
			$this->viewdata['cart_contents'] = Shpcart::cart($activecart)->contents();
			$this->viewdata['cart_total'] = Shpcart::cart($activecart)->total();
			$this->viewdata['order'] = $order;
			//render view
			$this->layout->content = View::make($this->viewpath('frontend.checkout.verify'), $this->viewdata);
		}

		public function verify($id)
		{
			$code = Input::get('code');

			$verify = Orders::verify($id, $code);

			if($verify)
			{
				//fire event
				Event::fire('order.verified', array("orderid"=>$id));
				//return response
				return Response::json(array('status'=>"success"));
			}
			else
			{
				return Response::json(array(
					'status'=>"error",
					"message"=>"Unable to verify order. Please ensure you have entered the correct verification code"
					));
			}
		}

		public function resendVerificationCode($id)
		{
			//generate new verification code
			$newcode = Orders::generateCode();
			//get order
			$order = Order::find($id);
			//set new verification
			$order->verification_code = $newcode;

			if($order->save())
			{
				//trigger order.placed event
				Event::fire('order.placed', array("order_id"=>$order->id));
				//Session flash message
				Session::flash('message', 'The verification message has been resent to you via email address and sms');

				return Redirect::to('order/'.$order->id.'/verify');
			}
		}

		public function complete($orderid)
		{
			$order = Order::with(array('restaurant','restaurant.meta'))->find($orderid);
			$activecart = Session::get('activecart');

			//View data
			$this->viewdata['restaurant'] = $order->restaurant;
			$this->viewdata['cart_contents'] = Shpcart::cart($activecart)->contents();
			$this->viewdata['cart_total'] = Shpcart::cart($activecart)->total();
			$this->viewdata['order'] = $order;
			//Destroy Cart
			Shpcart::cart($activecart)->destroy();
			//render view
			$this->layout->content = View::make($this->viewpath('frontend.checkout.complete'), $this->viewdata);	
		}
	}
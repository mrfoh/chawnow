<?php

	use Carbon\Carbon;
	
	class Orders
	{

		public static function all($status, $perPage = 15)
		{
			if($status == "all")
			{
				$orders = Order::with(array('restaurant','restaurant.meta'))
							   ->orderBy('created_at','desc')
							   ->paginate($perPage);
			}
			elseif($status == "placed")
			{
				$orders = Order::with(array('restaurant','restaurant.meta'))
							   ->where('status','=',"placed")
							   ->orderBy('created_at','desc')
							   ->paginate($perPage);
			}
			elseif($status == "verified")
			{
				$orders = Order::with(array('restaurant','restaurant.meta'))
							   ->where('status','=',"verified")
							   ->orderBy('created_at','desc')
							   ->paginate($perPage);	
			}
			elseif ($status == "fulfilled") 
			{
				$orders = Order::with(array('restaurant','restaurant.meta'))
							   ->where('status','=',"fulfilled")
							   ->orderBy('created_at','desc')
							   ->paginate($perPage);
			}

			return self::formatOrders($orders);
		}

		/**
		* Retrieves a restaurants orders
		* @access public
		* @param integer $restaurantid
		* @param string $status
		* @param integer $perPage
		* @return array
		**/
		public static function restaurant($restaurantid, $status, $perPage = 20)
		{
			if($status == "all")
			{
				$orders = Order::with(array('restaurant','restaurant.meta'))
							   ->where('restaurant_id','=', $restaurantid)
							   ->orderBy('created_at','desc')
							   ->paginate($perPage);
			}
			elseif($status == "placed")
			{
				$orders = Order::with(array('restaurant','restaurant.meta'))
							   ->where('restaurant_id','=', $restaurantid)
							   ->where('status','=',"placed")
							   ->orderBy('created_at','desc')
							   ->paginate($perPage);
			}
			elseif($status == "verified")
			{
				$orders = Order::with(array('restaurant','restaurant.meta'))
							   ->where('restaurant_id','=', $restaurantid)
							   ->where('status','=',"verified")
							   ->orderBy('created_at','desc')
							   ->paginate($perPage);	
			}
			elseif ($status == "fulfilled") 
			{
				$orders = Order::with(array('restaurant','restaurant.meta'))
							   ->where('restaurant_id','=', $restaurantid)
							   ->where('status','=',"fulfilled")
							   ->orderBy('created_at','desc')
							   ->paginate($perPage);
			}

			return self::formatOrders($orders);
		}

		public static function user($user_id, $perPage = 15)
		{
			$relationships = array('restaurant','items','items.item');
			$userorders = Order::with($relationships)
							   ->where('user_id','=', $user_id)
							   ->orderBy('created_at','desc')
							   ->paginate($perPage);

			return self::formatOrders($userorders);
		}

		private static function orderCost($order)
		{
			$total = 0;
			$subtotal = 0;
			if($order)
			{
				foreach($order->items as $orderitem)
				{
					$itemprice = $orderitem->qty * $orderitem->item->price;
					$total = $total + $itemprice;
					$subtotal = $total;
				}

				if($order->type == "delivery")
					$total = $total + $order->restaurant->meta->delivery_fee;

				return array('total' => $total, 'subtotal'=> $subtotal);
			}
			else
			{
				return false;
			}
		}

		private static function orderEta($order)
		{
			$orderdate = new Carbon($order->created_at);
			$readyin = (int) $order->restaurant->meta->delivery_time;

			$eta = $orderdate->addMinutes($readyin);

			return $eta;
		}

		private static function formatOrders($orders)
		{
			if($orders)
			{
				foreach($orders as $order)
				{
					$total = self::orderCost($order);
					$order->total = $total;
					$order->eta = self::orderEta($order);
				}

				return $orders;
			}
		}

		/**
		* Retrieves order
		* @access public
		* @param integer $id
		* @return object
		**/
		public static function get($id)
		{
			$relationships = array('items','items.item','restaurant','restaurant.meta','restaurant.area','restaurant.city');
			$order = Order::with($relationships)->find($id);

			$order->total = self::orderCost($order);

			return $order;
		}

		/**
		* Verifies a order
		* @param integer $id
		* ID of order
		* @param string $code
		* Verification code
		* @return boolean
		**/
		public static function verify($id, $code)
		{
			//get order
			$order = Order::find($id);

			if($order->verification_code == $code)
			{
				$order->status = "verified";
				$order->save();

				return true;
			}
			else
			{
				false;
			}
		}


		/**
		* Fulfills a order
		* @param integer $id
		* ID of order
		* @return boolean
		**/
		public static function fulfill($id)
		{
			//get order
			$order = Order::find($id);
			if($order)
			{
				$order->status = "fulfilled";

				if($order->save())
					return true;
				else
					return false;
			}
			else
			{
				return false;
			}
		}
		/**
		* Creates a new order
		* @param integer $restaurantid
		* @param string $type
		* @param boolean $guest
		* @param array $customer
		**/
		public static function createOrder($restaurantid, $type, $guest, $customer)
		{
			//new order model
			$order = new Order;
			//model attributes
			$order->restaurant_id = $restaurantid;
			$order->type = $type;
			$order->guest = (int) $guest;
			$order->user_id = (!$guest) ? Sentry::getUser()->id : NULL;
			$order->status = "placed";
			$order->verification_code = self::generateCode();

			foreach ($customer as $key => $value)
			{
				$order->$key = $value;
			}

			if($order->save())
			{
				self::createOrderItems($order->id);

				return $order->id;
			}
			else
			{
				return false;
			}
		}

		private static function createOrderItems($id)
		{
			//get active cart
			$activecart = Session::get('activecart');
			//cart contents
			$contents = Shpcart::cart($activecart)->contents();
			//loop through cart contents
			foreach($contents as $item)
			{
				//new orderitem model
				$orderitem = new OrderItem;
				//attributes
				$orderitem->order_id = $id;
				$orderitem->item_id = $item['id'];
				$orderitem->qty = $item['qty'];

				$orderitem->save();
			}

			return true;
		}

		private static function codeExist($code)
		{
			$order = Order::where('verification_code','=', $code)->first();
			if($order)
				return true;
			else
				return false;
		}

		private static function generate()
		{
			//code length
			$length = 5;
			//rand number
			$num = rand(1, 999999);
			$hash = substr(md5($num), 0, $length);

			return $hash;
		}

		public static function generateCode()
		{
			$code = self::generate();

			if(!self::codeExist($code))
				return $code;
			else
				return self::generate();
		}
	}
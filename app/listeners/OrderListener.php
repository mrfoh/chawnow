<?php

	class OrderListener
	{
		/**
		* Formats mobile numbers, add country code
		* @access private
		* @param string $no
		* @return string
		**/
		private function formatMobileNo($no)
		{
			if($no)
			{
				if(strlen($no) == 11)
				{
					$number = substr($no, 1, 10);
					$number = '234'.$number;

					return $number;
				}
			}
		}

		/**
		* Sends order verification message
		* @param integer $orderid
		**/
		public function placed($orderid)
		{
			$order = Order::with('restaurant')->find($order_id);

			$message = "You placed order to ".$order->restaurant->name.". Your verification code is: ".$order->verification_code.". Use this code to
			verfiy your order.";
			//Log
			Log::info($message);
			//mail customer
			$data['content'] = $message;
			$data['name'] = $order->customer_name;
			$data['order'] = $order;

			//Send mail
			Mail::later(10,'emails.orders.placed', $data, function($message) use ($order) {

				$message->to($order->customer_email, $order->customer_name)
						->subject('Order Verification');
			});

			//Send Sms
			$sms = new Sms;
			$reciepent = $this->formatMobileNo($order->customer_phone);
			$sendsms = $sms->sendMessage($reciepent, $message);
		}

		/**
		* Sends order verification message to restaurant
		* @param integer $orderid
		**/
		public function verified($orderid)
		{
			$order = Orders::get($orderid);

			//Notify restaurant via email
			$data['order'] = $order;

			Mail::later(10, 'emails.orders.verified', $data, function($message) use ($order) {

				$message->to($order->restaurant->email, $order->restaurant->name)
						->subject('New order #'.$order->id);
			});

			//Notify restaurant via sms	
			foreach($order->items as $oitems)
			{
				$orderitems[] = $oitems->item->name."x".$oitems->qty;
			}

			$message = "New order. Order Type:".ucwords($order->type).",Customer Name:".$order->customer_name.",Customer Address:".$order->customer_address.",Customer Phone:".$order->customer_phone.". Customer Order: ".implode(",", $orderitems);
			Log::info($message);
			
			$sms = new Sms;
			$reciepent = $this->formatMobileNo($order->restaurant->phone);
			$sendsms = $sms->sendMessage($reciepent, $message);
		}

		/**
		* Sends order confirmation message to restaurant
		* @param integer $orderid
		**/
		public function confirm($orderid)
		{
			$order = Orders::get($orderid);

			//Notify customer via email
			$data['order'] = $order;

			Mail::later(10,'emails.orders.verified', $data, function($message) use ($order) {

				$message->to($order->customer_email, $order->customer_name)
						->subject('Order Confirmation');
			});

			//Notify customer via sms
			$message = "Thank you for verifying your order. A confirmation email has been sent to: ".$order->customer_email.
			". Your order #".$order->id." will be delivered in:".$order->restaurant->meta->delivery_time.". Thank for using Chawnow :-)";

			//Log message
			Log::info($message);
			
			//Send Sms
			$sms = new Sms;
			$reciepent = $this->formatMobileNo($order->customer_phone);
			$sendsms = $sms->sendMessage($reciepent, $message);
		}
	}
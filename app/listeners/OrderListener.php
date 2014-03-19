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
					$number = substr($no, 1, 20);
					$number = '234'.$number;

					return $number;
				}

				elseif(strlen($no) > 11)
				{
					$phones = explode(",", $no);
					foreach($phones as $key => $value)
					{
						$number = substr($value, 1, 20);
						$number = '234'.$pho;
						$nos[] = $number;
					}

					return implode(",", $nos);
				}
			}
		}

		/**
		* Sends order verification message
		* @param integer $orderid
		**/
		public function placed($orderid)
		{
			$order = Order::with('restaurant')->find($orderid);

			$message = "You placed order to ".$order->restaurant->name.". Your verification code is: ".$order->verification_code.". Use this code to
			verfiy your order.";
			//Log
			Log::info($message);
			//mail customer
			$data['content'] = $message;
			$data['name'] = $order->customer_name;
			$data['order'] = $order;

			//Send mail
			Mail::later(20,'emails.orders.placed', $data, function($message) use ($order) {

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

			Mail::later(20, 'emails.orders.verified', $data, function($message) use ($order) {

				$message->to($order->restaurant->email, $order->restaurant->name)
						->subject('New order #'.$order->id);
			});

			//Notify restaurant via sms	
			foreach($order->items as $oitems)
			{
				if($oitems->options) {
					foreach(unserialize($oitems->options) as $key => $option) {
						$optionString = $key." = ".$option;
						$options[] = $optionString;
					}
				}

				$orderitems[] = $oitems->item->name."x".$oitems->qty."(".implode(",", $options).")";
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

			Mail::later(20,'emails.orders.confirm', $data, function($message) use ($order) {

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
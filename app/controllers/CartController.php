<?php
	
	class CartController extends Controller 
	{
		public function add()
		{
			$name = Input::get('name');
			$price = Input::get('price');
			$qty = (Input::get('qty')) ? Input::get('qty') : 1;
			$id = Input::get('id');
			$restaurant = Input::get('restaurant');

			$item = array("id"=>$id, "qty"=>$qty, "name"=>$name, "price"=>$price);

			$existing = Session::get('activecart');
			if($existing)
			{
				if($existing == $restaurant)
				{
					Shpcart::cart($restaurant)->insert($item);
				}
				else
				{
					Shpcart::cart($existing)->destroy();
					Session::put('activecart', $restaurant);

					Shpcart::cart($restaurant)->insert($item);
				}
			}
			else
			{
				Session::put('activecart', $restaurant);

				Shpcart::cart($restaurant)->insert($item);	
			}

			$contents = Shpcart::cart($restaurant)->contents();
			$carttotal = Shpcart::cart($restaurant)->total();

			return Response::json(array("status" => "success", "contents" => $contents, "total" => $carttotal));
		}

		public function increaseItemQty($rowid)
		{
			$existing = Session::get('activecart');
			$contents = Shpcart::cart($existing)->contents();

			foreach($contents as $content) {
				if($content['rowid'] == $rowid) {
					$item = $content;
				}
			}
			$qty = $item['qty'] + 1;
			$newitem = array("rowid"=>$rowid, "qty"=>$qty);
			Shpcart::cart($existing)->update($newitem);

			$contents = Shpcart::cart($existing)->contents();
			$carttotal = Shpcart::cart($existing)->total();

			return Response::json(array("status" => "success", "contents" => $contents, "total" => $carttotal, "item"=>$item));
		}

		public function reduceItemQty($rowid)
		{
			$existing = Session::get('activecart');
			$contents = Shpcart::cart($existing)->contents();

			foreach($contents as $content) {
				if($content['rowid'] == $rowid) {
					$item = $content;
				}
			}

			if($item['qty'] == 1) 
				$qty = 0;
			if($item['qty'] > 1)
				$qty = $item['qty'] - 1;

			$newitem = array("rowid"=>$rowid, "qty"=>$qty);
			Shpcart::cart($existing)->update($newitem);

			$contents = Shpcart::cart($existing)->contents();
			$carttotal = Shpcart::cart($existing)->total();

			return Response::json(array("status" => "success", "contents" => $contents, "total" => $carttotal));
		}

		public function clear()
		{
			Shpcart::cart()->destroy();
		}
	}
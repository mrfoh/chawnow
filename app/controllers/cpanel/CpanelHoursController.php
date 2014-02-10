<?php
	
	class CpanelHoursController extends CpanelController
	{

		public function index() {

			$schedules = RestaurantSchedule::where('restaurant_id','=',$this->restaurant->id)->get();

			$this->viewdata['schedules'] = $schedules;
			$this->viewdata['flashMessage'] = Session::get('message');

			$this->layout->content = View::make('cpanel.hours.index', $this->viewdata);
		}

		public function update() {

			$id = $this->restaurant->id;
			$daysofweek = array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");

			foreach($daysofweek as $day)
			{
				//find schedule
				$schedule = RestaurantSchedule::where('day','=', $day)->where('restaurant_id','=', $id)->first();

				$open = $day."_open_time";
				$close = $day."_close_time";

				$schedule->open_time = Input::get($open);
				$schedule->close_time = Input::get($close);

				$schedule->save();
			}

			Session::flash('message', 'Delivery and pick-up hours updated');
			return Redirect::to('hours');
		}
	}
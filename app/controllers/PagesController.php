<?php
	class PagesController extends BaseController 
	{
		public function __construct() 
		{
			parent::__construct();
			$this->layout = $this->setLayout('master');
		}

		/**
		* Displays the homepage
		**/
		public function home()
		{
			//get cities
			$cities = City::where('active','=',1)->get();;
			//get areas
			$areas = Area::with('city')->where('active','=',1)->get();

			//viewdata
			$this->viewdata['cities'] = $cities->toArray();
			$this->viewdata['areas']  = $areas->toArray();

			//render view
			$this->layout->content = View::make($this->viewpath('frontend.pages.home'), $this->viewdata);
		}

		public function about()
		{
			$this->layout->content = View::make($this->viewpath('frontend.pages.about'), $this->viewdata);
		}

		public function howItWorks()
		{
			$this->layout->content = View::make($this->viewpath('frontend.pages.howitworks'), $this->viewdata);
		}

		public function contact()
		{
			$this->layout->content = View::make($this->viewpath('frontend.pages.contact'), $this->viewdata);
		}

		public function faq()
		{
			$this->layout->content = View::make($this->viewpath('frontend.pages.faq'), $this->viewdata);
		}
	}
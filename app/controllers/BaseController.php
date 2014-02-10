<?php

class BaseController extends Controller {

	public $viewdata = array();

	public $isLoggedin = false;

	public $user;

	public $profile;
	
	public $device = "desktop";

	public function __construct()
	{
		if(Sentry::check()) {
			$this->isLoggedin = true;
			$this->user = Sentry::getUser();
			$this->profile = Profile::where('user_id','=',$this->user->id)->first();
		}
		else {
			$this->isLoggedin = false;
		}

		$this->viewdata['isLoggedin'] = $this->isLoggedin;
		//Detect device
		$this->deviceDetect();

		//retrieve and cache site wide data
		$cuisines = Cuisine::with('restaurants')->remember(60)->get();

		View::share('cuisines', $cuisines);
		View::share('isLoggedin', $this->isLoggedin);
	}

	private function deviceDetect() 
	{
		//Instantiate mobile detect class
		$detect = new Mobile_Detect;
		$this->device = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'desktop');
	}

	public function setLayout($layout)
	{
		if($this->device == "phone" || $this->device == "tablet")
			$path = 'frontend.layouts.mobile.'.$layout;

		if($this->device == "desktop")
			$path = 'frontend.layouts.desktop.'.$layout;

		return $path;
	}
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function viewpath($viewpath)
	{
		if($viewpath)
		{
			$parts = explode(".", $viewpath);

			if($this->device == "desktop") {
				return $parts[0].".".$parts[1].".desktop.".$parts[2];
			}	
			elseif($this->device == "phone" || $this->device == "tablet") {
				return $parts[0].".".$parts[1].".mobile.".$parts[2];
			}
		}
	}
}
<?php namespace App\Http\Controllers;

use Session;
use Route;
use Input;
use App\Gps;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class GpsController extends Controller {

	public function index()
	{
		$gpsaddr=Input::get('gpsaddr');
		if($gpsaddr){
			Gps::updatebyaddress($gpsaddr);
		}else{
			Session::flash('gpsautodetect', 1);
		}
		return redirect('/#gps');		
	}
}

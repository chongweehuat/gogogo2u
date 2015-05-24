<?php namespace App\Http\Controllers\User;

use Auth;
use Input;
use Session;

use App\Gps;
use App\Image;
use App\Event;
use App\Business;
use App\Business_code;
use App\Business_domain;
use App\Business_chainstore;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;

class BusinessController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$currentUser = Auth::user();		
		if($currentUser->biz_count<2){
			return redirect('/dashboard/managebusiness');
		}else{
			$business=Business::blist();
			return view('user.businesslist',compact('business'));
		}
	}

	public function gethtml($code)
	{
		$html='';
		if($code=='code'){
			$c=Business_code::code();
			if(empty($c))$c='"code"';
			$html=$c;
		}elseif($code=='domainname'){
			$d=Business_domain::domain();
			if(empty($d))$d='"Your Domain Name"';
			$html=$d;
		}elseif($code=='wechat'){
			$image_id=Business::get('mainpages.wechat_image_id');
			if($image_id){
				$html.='<a href="'.Business::get('mainpages.wechat_url').'">';
				$html.='<img src="'.Image::url(Business::get('mainpages.wechat_image_id')).'"'; 
				$html.=' style="max-width:300px;">';
				$html.='</a>';
			}else{
				$html.='<a href="/dashboard/album/">Manage Album</a>';
			}
		}elseif($code=='eventwechat'){
			$image_id=Business::get('events.wechat_image_id');
			if($image_id){
				$html.='<a href="'.Business::get('events.wechat_url').'">';
				$html.='<img src="'.Image::url(Business::get('events.wechat_image_id')).'"'; 
				$html.=' style="max-width:300px;">';
				$html.='</a>';
			}else{
				$html.='<a href="/dashboard/album/">Manage Album</a>';
			}
		}elseif($code=='gps'){
			$gps_id=Business::get('business.gps_id');
			if($gps_id){
				$html.=Gps::find(Business::get('business.gps_id'))->gps_address;
				$html.='<br><br>';
				$html.=Gps::googlemapbyid(Business::get('business.gps_id'));
			}
		}elseif($code=='gpslatlng'){
			$gps_id=Business::get('business.gps_id');
			if($gps_id){
				$gps=Gps::find($gps_id);
				$html.=$gps->lat.','.$gps->lng;
			}
		}elseif($code=='eventgpslatlng'){
			$gps_id=Business::get('events.gps_id');
			if($gps_id){
				$gps=Gps::find($gps_id);
				$html.=$gps->lat.','.$gps->lng;
			}
		}elseif($code=='bcs'){
			$html.=Business_chainstore::select();
		}		
		
		return $html;
	}

	public function update()
	{
		$aresult=Business::updatefn(Input::get('fn'));

		return response()->json($aresult);
	}

	public function manage()
	{ 
		Business::manage(Input::get('id',0));

		$sp=Input::get('sp');
		if($sp)Session::put('business.subpage_id',$sp);
		
		$s=Input::get('s','basic');
		$business=array(
			'section'=>Business::section($s),
			's'=>$s,
		);

		if(Session::has('business.id') and Session::get('business.id')){
			return view('user.managebusiness',compact('business'));
		}else{
			return redirect('/dashboard/business');
		}
	}

	public function event()
	{ 
		Business::manage(0);

		$ev=Input::get('ev');
		if($ev)Session::put('business.event_id',$ev);

		$s=Input::get('s','basic');
		$event=array(
			'section'=>Event::section($s),
			's'=>$s,
		);
		if(Session::has('business.event_id') and Session::get('business.event_id')){
			return view('user.event.manageevent',compact('event'));
		}else{
			return redirect('/dashboard/managebusiness/?s=events');
		}
	}
}
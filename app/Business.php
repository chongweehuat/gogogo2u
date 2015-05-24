<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Business_user;
use App\Mainpage;

use Session;
use Auth;

class Business extends Model {

	protected $fillable = ['*'];

	public static function section($s){
		$asection=array('Basic','Album','Location','Contact','Links','Setting','Subpages','Events');
		$html='';
		foreach($asection as $k=>$section){
			$v=strtolower($section);
			if($v==$s){
				$html.="<span style='font-size:120%;'>$section</span>";
			}else{
				$html.="<a href=?s=$v>$section</a>";				
			}
			if($k<count($asection)-1){
				if($k<5)$html.=" | ";
				else $html.=" || ";
			}
		}
		return $html;
	}

	public static function updatefn($fv){
		update_session();
		$aresult=['error'=>'Update Error','success'=>false];
		foreach($fv as $fn=>$v){
			$afn=explode('.',$fn);
			$table=$afn[0];
			$fieldname=$afn[1];
			if($table=='mainpages'){
				$aresult=Mainpage::validupdate($fieldname,$v);
				if($aresult['success'] and $fieldname=='address'){
					if($v){
						$gps_id=Gps::getaddressgpsid($v);
						if($gps_id)$aresult=Business::validupdate('gps_id',$gps_id);
						else $aresult=['success'=>false,'error'=>'Invalid Address'];
					}else{
						$aresult=Business::validupdate('gps_id',0);
					}
				}
			}elseif($table=='subpages'){
				$aresult=Subpage::validupdate($fieldname,$v);
			}elseif($table=='events'){
				$aresult=Event::validupdate($fieldname,$v);
				if($aresult['success'] and $fieldname=='address'){
					if($v){
						$gps_id=Gps::getaddressgpsid($v);
						if($gps_id)$aresult=Event::validupdate('gps_id',$gps_id);
						else $aresult=['success'=>false,'error'=>'Invalid Address'];
					}else{
						$aresult=Event::validupdate('gps_id',0);
					}
				}
			}elseif($table=='business'){
				$aresult=Business::validupdate($fieldname,$v);
			}elseif($table=='gps'){
				
				$a=explode(',',$v);
				$lat=floatval($a[0]);
				if(isset($a[1]))$lng=floatval($a[1]);
				else $lng=0;
				if($lat>0 and $lng>0){
					$gps_id=Gps::getlocationgpsid($lat,$lng);
					if($gps_id)$aresult=Business::validupdate('gps_id',$gps_id);
					else $aresult=['success'=>false,'error'=>'Invalid GPS Coordinate'];
				}else{
					$aresult=['success'=>true];
				}
			}elseif($table=='eventgps'){
				
				$a=explode(',',$v);
				$lat=floatval($a[0]);
				if(isset($a[1]))$lng=floatval($a[1]);
				else $lng=0;
				if($lat>0 and $lng>0){
					$gps_id=Gps::getlocationgpsid($lat,$lng);
					if($gps_id)$aresult=Event::validupdate('gps_id',$gps_id);
					else $aresult=['success'=>false,'error'=>'Invalid GPS Coordinate'];
				}else{
					$aresult=['success'=>true];
				}		
			}elseif($table=='table'){
				if($fieldname=='code'){
					if(Business_code::savecode($v))$aresult=['success'=>true];
					else $aresult=['success'=>false,'error'=>'Duplicate Code'];
				}elseif($fieldname=='domain'){
					if(Business_domain::savedomain($v))$aresult=['success'=>true];
					else $aresult=['success'=>false,'error'=>'Duplicate Domain'];
				}elseif($fieldname=='chainstore'){
					if(Business_chainstore::savecode($v))$aresult=['success'=>true];
					else $aresult=['success'=>false,'error'=>'Invalid Chain Store Code'];
				}elseif($fieldname=='eventtag'){
					if(Event::savetag($v))$aresult=['success'=>true];
					else $aresult=['success'=>false,'error'=>'Invalid Tag'];
				}elseif($fieldname=='businesstag'){
					if(Business::savetag($v))$aresult=['success'=>true];
					else $aresult=['success'=>false,'error'=>'Invalid Tag'];
				}
			}			
		}
		return $aresult;
	}

	public static function validupdate($fieldname,$v){				
		$aresult=['success'=>true];
		$business=Business::find(Session::get('business.id'));
		$business->$fieldname=$v;
		$business->save();
		return $aresult;
	}

	public static function get($fn){
		update_session();
		$afn=explode('.',$fn);
		$table=$afn[0];
		$fieldname=$afn[1];
		if($table=='mainpages'){
			$v=Mainpage::getval($fieldname);
		}elseif($table=='subpages'){
			$v=Subpage::getval($fieldname);
		}elseif($table=='events'){
			$v=Event::getval($fieldname);
		}elseif($table=='business'){
			$v=Business::find(Session::get('business.id'))->$fieldname;
		}elseif($table=='gps'){
			$gps_id=Business::find(Session::get('business.id'))->gps_id;
			if($gps_id){
				$gps=Gps::find($gps_id);				
				if(isset($gps->lat))$v=$gps->lat.','.$gps->lng;
			}else $v='';
		}elseif($table=='eventgps'){
			$gps_id=Event::find(Session::get('business.event_id'))->gps_id;
			if($gps_id){
				$gps=Gps::find($gps_id);				
				if(isset($gps->lat))$v=$gps->lat.','.$gps->lng;
			}else $v='';
		}elseif($table=='table'){
			if($fieldname=='code'){				
				$v=Business_code::code();
			}elseif($fieldname=='domain'){				
				$v=Business_domain::domain();
			}elseif($fieldname=='chainstore'){
				$business=Business::find(Session::get('business.id'));
				if(isset($business->chainstore_id) and $business->chainstore_id)$v=Business_chainstore::find($business->chainstore_id)->code;
				else $v='';
			}elseif($fieldname=='businesstag'){
				$v=Business_tag::tagid();
			}elseif($fieldname=='bselectedtag'){
				$v=Business_tag::taglist();
			}elseif($fieldname=='eventtag'){
				$v=Event_tag::tagid();
			}elseif($fieldname=='eselectedtag'){
				$v=Event_tag::taglist();
			}
		}
		return $v; 
	}

	public static function blist(){
		$currentUser = Auth::user();
		$business_user=Business_user::where('user_id','=',$currentUser->id)->get();
		$addbusiness=true;
		if($currentUser->biz_count<=count($business_user))$addbusiness=false;
		foreach($business_user as $k=>$v){
			$business=Mainpage::where('business_id','=',$v->business_id)->get();
			if(count($business)){
				$business_user[$k]->title=$business[0]->title;
				if(empty($business[0]->title))$addbusiness=false;
			}else{
				$addbusiness=false;
			}
		}

		if($addbusiness){
			$business=Business::create(['status'=>0]);
			Business_user::create(['business_id'=>$business->id,'user_id'=>$currentUser->id,'role'=>'creater']);
		}

		return $business_user;
	}

	public static function manage($id){
		$currentUser = Auth::user();

		if($id){			
			$business_user=Business_user::where('business_id','=',$id)->where('user_id','=',$currentUser->id)->get();
		}else{
			$business_user=Business_user::where('user_id','=',$currentUser->id)->get();			
		}
		if(count($business_user)){
			$business_id=$business_user[0]->business_id;
		}else{
			$business=Business::create(['status'=>0]);
			$business_id=$business->id;
			Business_user::create(['business_id'=>$business->id,'user_id'=>$currentUser->id,'role'=>'creater']);
		}
		Session::put('business.id',$business_id);
	}

	public static function savetag($aids){
		$business_id=Session::get('business.id');
		if(empty($business_id))return false;
		$datetime=date('Y-m-d H:i:s');
		foreach($aids as $id){
			$tag=Tag::find($id);
			if(count($tag)){
				$business_tag=Business_tag::firstOrCreate(['business_id'=>$business_id,'tag_id'=>$id]);
				$business_tag->business_id=$business_id;
				$business_tag->tag_id=$id;
				$business_tag->updated_at=date('Y-m-d H:i:s');
				$business_tag->save();
			}else{
				$tag_kiv=Tag_kiv::firstOrCreate(['module'=>'business','module_id'=>$business_id,'code'=>$id]);
				$tag_kiv->module='business';
				$tag_kiv->module_id=$business_id;
				$tag_kiv->code=$id;
				$tag_kiv->updated_at=date('Y-m-d H:i:s');
				$tag_kiv->save();
			}
		}

		Business_tag::where('business_id','=',$business_id)->where('updated_at','<',$datetime)->delete();
		Tag_kiv::where('module_id','=',$business_id)->where('module','=','business')->where('updated_at','<',$datetime)->delete();
		return true;
	}
}
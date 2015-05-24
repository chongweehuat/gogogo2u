<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Session;

class Event extends Model {

	protected $fillable = ['*'];

	public static function section($s){
		$asection=array('Basic','Album','Location','Contact','Links','Setting');
		$html='';
		foreach($asection as $k=>$section){
			$v=strtolower($section);
			if($v==$s){
				$html.="<span style='font-size:120%;'>$section</span>";
			}else{
				$html.="<a href=?s=$v>$section</a>";				
			}
			if($k<count($asection)-1){
				$html.=" | ";				
			}
		}
		return $html;
	}

	public static function manage(){
		$business_id=Session::get('business.id');
		if($business_id){
			$events=Event::where('business_id','=',$business_id)
				->where('language_id','=',Session::get('search.language_id'))
				->where('title','=','')->get();
			if(count($events)==0){
				$event=Event::create(['business_id'=>$business_id]);
				$event->business_id=$business_id;
				$event->language_id=Session::get('search.language_id');
				$event->save();
			}
		}
	}

	public static function activelist(){
		return Event::where('business_id','=',Session::get('business.id'))
			->where('language_id','=',Session::get('search.language_id'))->get();
	}

	public static function getval($fieldname){		
		$event=Event::find(Session::get('business.event_id'));
		return $event->$fieldname;		
	}

	public static function validupdate($fieldname,$v){		
		$aresult=['success'=>true];
		$event=Event::find(Session::get('business.event_id'));
		$event->$fieldname=$v;
		$event->save();
		return $aresult;
	}

	public static function savetag($aids){
		$event_id=Session::get('business.event_id');
		if(empty($event_id))return false;
		$datetime=date('Y-m-d H:i:s');
		foreach($aids as $id){
			$tag=Tag::find($id);
			if(count($tag)){
				$event_tag=Event_tag::firstOrCreate(['event_id'=>$event_id,'tag_id'=>$id]);
				$event_tag->event_id=$event_id;
				$event_tag->tag_id=$id;
				$event_tag->updated_at=date('Y-m-d H:i:s');
				$event_tag->save();
			}else{
				$tag_kiv=Tag_kiv::firstOrCreate(['module'=>'event','module_id'=>$event_id,'code'=>$id]);
				$tag_kiv->module='event';
				$tag_kiv->module_id=$event_id;
				$tag_kiv->code=$id;
				$tag_kiv->updated_at=date('Y-m-d H:i:s');
				$tag_kiv->save();
			}
		}

		Event_tag::where('event_id','=',$event_id)->where('updated_at','<',$datetime)->delete();
		Tag_kiv::where('module_id','=',$event_id)->where('module','=','event')->where('updated_at','<',$datetime)->delete();
		return true;
	}

}

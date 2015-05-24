<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Session;

class Event_tag extends Model {

	protected $fillable = ['*'];

	public static function tagid(){
		$event_tags=Event_tag::where("event_id","=",Session::get('business.event_id'))->get();
		$a=array();
		if(count($event_tags)){			
			foreach($event_tags as $event_tag){
				$a[]=$event_tag->tag_id;
			}
		}
		$tag_kivs=Tag_kiv::where("module_id","=",Session::get('business.event_id'))->where("module","=",'event')->get();
		if(count($tag_kivs)){			
			foreach($tag_kivs as $tag_kiv){
				$a[]=$tag_kiv->code;
			}
		}
		return $a;
	}

	public static function taglist(){
		$event_tags=Event_tag::where("event_id","=",Session::get('business.event_id'))->get();
		$a=array();
		if(count($event_tags)){
			$language_id=Session::get('search.language_id');
			foreach($event_tags as $event_tag){
				if($language_id==37){
					$a[$event_tag->tag_id]=Tag::find($event_tag->tag_id)->code;
				}else{
					$a[$event_tag->tag_id]=Tag_language::where('tag_id','=','$event_tag->tag_id')->where('language_id','=',$language_id)->code;
				}
			}
		}
		$tag_kivs=Tag_kiv::where("module_id","=",Session::get('business.event_id'))->where("module","=",'event')->get();
		if(count($tag_kivs)){			
			foreach($tag_kivs as $tag_kiv){
				$a[$tag_kiv->code]='*'.$tag_kiv->code.'*';
			}
		}
		return $a;
	}

}

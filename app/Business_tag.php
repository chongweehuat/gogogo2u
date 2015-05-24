<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Session;

class Business_tag extends Model {

	protected $fillable = ['*'];

	public static function tagid(){
		$business_tags=Business_tag::where("business_id","=",Session::get('business.id'))->get();
		$a=array();
		if(count($business_tags)){			
			foreach($business_tags as $business_tag){
				$a[]=$business_tag->tag_id;
			}
		}
		$tag_kivs=Tag_kiv::where("module_id","=",Session::get('business.id'))->where("module","=",'business')->get();
		if(count($tag_kivs)){			
			foreach($tag_kivs as $tag_kiv){
				$a[]=$tag_kiv->code;
			}
		}
		return $a;
	}

	public static function taglist(){
		$business_tags=Business_tag::where("business_id","=",Session::get('business.id'))->get();
		$a=array();
		if(count($business_tags)){
			$language_id=Session::get('search.language_id');
			foreach($business_tags as $business_tag){
				if($language_id==37){
					$a[$business_tag->tag_id]=Tag::find($business_tag->tag_id)->code;
				}else{
					$a[$business_tag->tag_id]=Tag_language::where('tag_id','=','$business_tag->tag_id')->where('language_id','=',$language_id)->code;
				}
			}
		}
		$tag_kivs=Tag_kiv::where("module_id","=",Session::get('business.id'))->where("module","=",'business')->get();
		if(count($tag_kivs)){			
			foreach($tag_kivs as $tag_kiv){
				$a[$tag_kiv->code]='*'.$tag_kiv->code.'*';
			}
		}
		return $a;
	}

}

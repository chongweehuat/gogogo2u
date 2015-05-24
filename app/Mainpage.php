<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Session;
use Validator;

class Mainpage extends Model {

	protected $fillable = ['*'];

	public static function validupdate($fieldname,$v){
		if($fieldname=='email'){
			$validator = Validator::make([$fieldname=>$v], ['email'=>'email']);
			if($validator->fails()){
				$amsgs=$validator->messages()->all();				
				return [
					'success'=>false,
					'error'=>$amsgs[0],
					];
			}
		}
		$aresult=['success'=>true];
		$business_id=Session::get('business.id');
		$language_id=Session::get('search.language_id');
		$mainpage=Mainpage::firstorcreate(['business_id'=>$business_id,'language_id'=>$language_id]);
		$mainpage->business_id=$business_id;
		$mainpage->language_id=$language_id;
		$mainpage->$fieldname=$v;
		$mainpage->save();
		return $aresult;
	}

	public static function getval($fieldname){
		$business_id=Session::get('business.id');
		$language_id=Session::get('search.language_id');
		$mainpage=Mainpage::where('business_id','=',$business_id)->where('language_id','=',$language_id)->get();
		if(count($mainpage))return $mainpage[0]->$fieldname;
		else return '';
	}
}

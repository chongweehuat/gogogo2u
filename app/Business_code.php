<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Session;

class Business_code extends Model {

	protected $fillable = ['*'];

	public static function code(){
		if(Session::has('business.id')){
			$business_code=Business_code::where('business_id','=',Session::get('business.id'))->get();
			if(count($business_code)){
				$code=$business_code[0]->code;
			}else{
				for ($i = 1; $i <= 10; $i++) {
					$code=substr(MD5(rand(1000,999999999)),rand(0,10),10);
					$afield=['business_id'=>Session::get('business.id'),'code'=>$code];
					$business_code=new Business_code;
					$business_code->business_id=Session::get('business.id');
					$business_code->code=$code;

					$bc=Business_code::where('code','=',$code)->get();
					if(count($bc)==0){
						$business_code->save();
						break;
					}
				}

			}
			return $code;
		}else{
			return '';
		}
	}

	public static function savecode($code){
		$business_code=Business_code::where('code','=',$code)->get();
		if(count($business_code)){
			return false;
		}else{
			$business_code=Business_code::where('business_id','=',Session::get('business.id'))->get();
			$bc=Business_code::find($business_code[0]->id);
			$bc->code=$code;
			return $bc->save();
		}
	}

}

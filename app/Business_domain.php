<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Session;

class Business_domain extends Model {

	protected $fillable = ['*'];

	public static function domain(){
		if(Session::has('business.id')){
			$business_domain=Business_domain::where('business_id','=',Session::get('business.id'))->get();
			if(count($business_domain)){
				$domain=$business_domain[0]->domain;
			}else{
				$domain='';
			}
			return $domain;
		}else{
			return '';
		}
	}

	public static function savedomain($domain){
		$business_domain=Business_domain::where('domain','=',$domain)->get();
		if(count($business_domain) and $business_domain[0]->business_id<>Session::get('business.id')){
			return false;
		}else{
			$business_domain=Business_domain::where('business_id','=',Session::get('business.id'))->get();
			if(count($business_domain)){
				$bd=Business_domain::find($business_domain[0]->id);
			}else{
				$bd=Business_domain::create(['business_id'=>Session::get('business.id')]);
				$bd->business_id=Session::get('business.id');
			}
			$bd->domain=$domain;
			return $bd->save();
		}
	}

}

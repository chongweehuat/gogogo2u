<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Session;
use Form;
use Auth;

use App\Business;

class Business_chainstore extends Model {

	protected $fillable = ['*'];

	public static function savecode($code){
		$business=Business::find(Session::get('business.id'));

		if($code){
			$currentUser = Auth::user();
			$bcs=Business_chainstore::firstorcreate(['user_id'=>$currentUser->id,'code'=>$code]);
			$bcs->user_id=$currentUser->id;
			$bcs->code=$code;
			$bcs->save();
			$business->chainstore_id=$bcs->id;
		}else{
			$business->chainstore_id=0;
		}
		return $business->save();
	}

	public static function select(){
		if(Session::has('business.id')){
			$html=Form::text('fn[table.chainstore]', Business::get('table.chainstore'), array('id'=>'chainstorecode','class'=>'form-control','placeholder'=>'Enter Chain Store Code'));

			$currentUser = Auth::user();
			$bcs=Business_chainstore::where('user_id','=',$currentUser->id)->get();
			if(count($bcs)){
				$html.="<select class='form-control' name=bcs id='selectbcs' onchange='updatecode()'>";
				$html.="<option value=''>select code</option>";	
				foreach($bcs as $bc){
					$html.="<option value='{$bc->code}'>{$bc->code}</option>";
				}
				$html.='</select>';
			}
			return $html;
		}else{
			return '';
		}
	}

}

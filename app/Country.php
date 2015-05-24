<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

	public static function select(){
		$country_id=Business::get('business.country_id');
		if(empty($country_id))$country_id=130;
		$country=Country::all();
		$html='<select id="country_id" name="fn[business.country_id]" class="form-control">';
		$html.="<option value=0>select Country</option>";
		foreach($country as $c){
			$selected='';
			if($c->id==$country_id)$selected='SELECTED';
			$html.="<option value={$c->id} $selected>{$c->name}</option>";
		}
		$html.='</select>';
		return $html;
	}

}

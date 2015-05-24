<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Session;
use DB;

class Category extends Model {

	protected $fillable = ['name','parent_id','level','seqno'];

	public static function categorylist(){
		$category_id=Session::get('search.category_id');

		$language_id=Session::get('search.language_id');
		
		$acategories=DB::table('categories')->where('level','=',1)->orderBy('name')->get();

		$html='<select name=category_id class="form-control" onchange=submit()>';
		$html.='<option value=0>'.trns('general.all').'</option>';
		foreach($acategories as $acategory){
			$selected='';
			if($category_id==$acategory->id)$selected='SELECTED';
			$html.='<option '.$selected.' value='.$acategory->id.'>';
			if($language_id==37){
				$html.=$acategory->name;
			}else{
				$catlg=DB::table('category_languages')->where('category_id','=',$acategory->id)->where('language_id','=',$language_id)->get();
				if(isset($catlg[0]))$html.=$catlg[0]->name;
			}
			$html.='</option>';
		}
		$html.='</select>';

		return $html;
	}

	public static function subcategorylist(){
		$category_id=Session::get('search.category_id');
		$subcategory_id=Session::get('search.subcategory_id');

		$language_id=Session::get('search.language_id');

		$html='';
		if($category_id){
			$acategories=DB::table('categories')->where('parent_id','=',$category_id)->orderBy('name')->get();

			$html='<select name=subcategory_id class="form-control" onchange=submit()>';
			$html.='<option value=0>-------</option>';
			foreach($acategories as $acategory){
				$selected='';
				if($subcategory_id==$acategory->id)$selected='SELECTED';
				$html.='<option '.$selected.' value='.$acategory->id.'>';
				if($language_id==37){
					$html.=$acategory->name;
				}else{
					$catlg=DB::table('category_languages')->where('category_id','=',$acategory->id)->where('language_id','=',$language_id)->get();
					if(isset($catlg[0]))$html.=$catlg[0]->name;
				}
				$html.='</option>';
			}
			$html.='</select>';
		}
		return $html;
	}

}

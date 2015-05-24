<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Session;

class Subpage extends Model {

	protected $fillable = ['*'];

	public static function manage(){
		$business_id=Session::get('business.id');
		if($business_id){
			$subpages=Subpage::where('business_id','=',$business_id)
				->where('language_id','=',Session::get('search.language_id'))
				->where('title','=','')->get();
			if(count($subpages)==0){
				$subpage=Subpage::create(['business_id'=>$business_id]);
				$subpage->business_id=$business_id;
				$subpage->language_id=Session::get('search.language_id');
				$subpage->save();
			}
		}
	}

	public static function activelist(){
		return Subpage::where('business_id','=',Session::get('business.id'))
			->where('language_id','=',Session::get('search.language_id'))->get();
	}

	public static function getval($fieldname){		
		$subpage=Subpage::find(Session::get('business.subpage_id'));
		return $subpage->$fieldname;		
	}

	public static function validupdate($fieldname,$v){		
		$aresult=['success'=>true];
		$subpage=Subpage::find(Session::get('business.subpage_id'));
		$subpage->$fieldname=$v;
		$subpage->save();
		return $aresult;
	}

	public static function selectpagetype(){
		$html='<select id="pagetype" name="fn[subpages.pagetype]" class="form-control">';
		$html.="<option value=''>select page type</option>";
		$subpage=Subpage::find(Session::get('business.subpage_id'));
		$pagetypes=Subpage::pagetype();
		foreach($pagetypes as $k=>$pagetype){
			$selected='';
			if($k==$subpage->pagetype)$selected='SELECTED';
			$html.="<option value='$k' $selected>$pagetype</option>";
		}
		$html.='</select>';
		return $html;
	}

	public static function pagetype(){
		return [
			'about'=>'about',
			'contact'=>'contact',
			'privacy'=>'privacy',
			'terms'=>'terms',
			'section1'=>'section 1',
			'section2'=>'section 2',
			'section3'=>'section 3'
		];
	}

}

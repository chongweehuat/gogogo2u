<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Session;
use DB;
use App;

class Tag extends Model {

	protected $fillable = ['code','ncount','branded','user_id'];

	public function categories(){
		return $this->hasMany('App\Tag_category', 'tag_id');
	}

	public static function manage(){
		if (!Session::has('search.mode')){
			Session::put('search.mode','business');
		}
		if (!Session::has('search.distance')){
			Session::put('search.distance',10);
		}
		if (!Session::has('search.q')){
			Session::put('search.q','');
		}
		if (!Session::has('search.category_id')){
			Session::put('search.category_id',0);
		}
		if (!Session::has('search.subcategory_id')){
			Session::put('search.subcategory_id',0);
		}
	}

	public static function saveinput($input){
		if(isset($input['searchmode']))Session::put('search.mode',$input['searchmode']);
		if(isset($input['searchdistance']))Session::put('search.distance',$input['searchdistance']);
		if(isset($input['q']) or isset($input['tag_id'])){
			if(isset($input['q'])){
				$tag=DB::table('tags')->where('code','=',$input['q'])->get();
				if(isset($tag[0]))$tag_id=$tag[0]->id;
				else $tag_id=0;
				if(empty($tag_id)){
					$tag=DB::table('tag_languages')->where('code','=',$input['q'])->get();
					if(isset($tag[0]))$tag_id=$tag[0]->tag_id;
				}
				if($tag_id){
					Session::put('search.tag_id',$tag_id);
					Session::put('search.q',$input['q']);
				}else{
					flash('Invalid Tag - '.$input['q']);
				}
			}else{				
				Session::put('search.tag_id',$input['tag_id']);

				$language_id=Session::get('search.language_id');
				if($language_id==37){
					Session::put('search.q',Tag::find($input['tag_id'])->code);				
				}else{
					$tag_lg=DB::table('tag_languages')->where('tag_id','=',$input['tag_id'])->where('language_id','=',$language_id)->get();
					if(isset($tag_lg[0])){
						Session::put('search.q',$tag_lg[0]->code);				
					}
				}
			}
			Session::put('search.type','TAG');
		}
		if(isset($input['searchtype'])){
			if($input['searchtype']=='List All'){
				Session::put('search.q',trns('general.listall'));
				Session::put('search.type','ALL');
			}else{
				Session::put('search.type','TAG');
			}
		}

		if(isset($input['category_id']))Session::put('search.category_id',$input['category_id']);
		if(isset($input['subcategory_id']))Session::put('search.subcategory_id',$input['subcategory_id']);
	}

	public static function taglist(){
		$category_id=Session::get('search.category_id');
		$subcategory_id=Session::get('search.subcategory_id');
		
		update_session();
		$language_id=Session::get('search.language_id');

		$html='';	
		if($category_id){			
			$acategory_id=array();
			if($subcategory_id){
				$acategory_id[]=$subcategory_id;
			}else{
				$acategory_id[]=$category_id;
				$asubcategory=DB::table('categories')->where('parent_id','=',$category_id)->get();
				foreach($asubcategory as $v){
					$acategory_id[]=$v->id;
				}
			}
				
			foreach($acategory_id as $id){
				$atags=DB::table('tag_categories')->where('category_id','=',$id)->get();
				foreach($atags as $tag){
					$atag=Tag::find($tag->tag_id);
					$html.="<a href='/search/?tag_id={$tag->tag_id}'>#";
					if($language_id==37){
						$html.=$atag->code;
					}else{
						$tag_lg=DB::table('tag_languages')->where('tag_id','=',$tag->tag_id)->where('language_id','=',$language_id)->get();
						if(isset($tag_lg[0]))$html.=$tag_lg[0]->code;
					}
					$html.='</a>&nbsp;';
				}
			}
			
		}else{
			$atags=DB::table('tags')->orderBy('ncount','desc')->take(18)->get();
			
			foreach($atags as $atag){
				$q=urlencode($atag->code);
				$html.="<a href='/search/?tag_id={$atag->id}'>#";
				if($language_id==37){
					$html.=$atag->code;
				}else{
					$tag_lg=DB::table('tag_languages')->where('tag_id','=',$atag->id)->where('language_id','=',$language_id)->get();
					if(isset($tag_lg[0]))$html.=$tag_lg[0]->code;
				}
				$html.='</a>&nbsp;';
			}
		}		

		if(empty($html))$html="<a>No Tags Found !</a>";
		return '<br>'.$html;
	}

	public static function searchmode(){
		if(Session::get('search.mode')=='business')$checked='CHECKED';
		else $checked='';
		$html='<input name="searchmode" type="radio" value="business" '.$checked.'> <strong>'.trns('general.business').'</strong>';

		if($checked)$checked='';
		else $checked='CHECKED';

		$html.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$html.='<input name="searchmode" type="radio" value="event" '.$checked.'> <strong>'.trns('general.event').'</strong>';

		$html.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$html.='<strong>'.trns('general.distance').':</strong> <input type=text value="'.Session::get('search.distance').'" name=searchdistance size=1 class="" style="color:blue;"> '.trns('general.km');

		return $html;
	}

	public static function select2($q=''){
		$language_id=Session::get('search.language_id');
		$atag=array();
		if($language_id==37){
			$tag=Tag::where('code','like',"{$q}%")->get();
			if(count($tag)){
				foreach($tag as $t){
					$atag[]=['id'=>$t->id,'text'=>$t->code];
				}
			}else{
				$tag=Tag_language::where('code','like',"{$q}%")->get();
				foreach($tag as $t){
					$atag[]=['id'=>$t->tag_id,'text'=>$t->code];
				}
			}
		}else{
			$tag=Tag_language::where('language_id','=',$language_id)->where('code','like',"{$q}%")->get();
			if(count($tag)){
				foreach($tag as $t){
					$atag[]=['id'=>$t->tag_id,'text'=>$t->code];
				}
			}else{
				$tag=Tag::where('code','like',"{$q}%")->get();
				if(count($tag)){
					foreach($tag as $t){
						$atag[]=['id'=>$t->id,'text'=>$t->code];
					}
				}else{
					$tag=Tag_language::where('code','like',"{$q}%")->get();
					foreach($tag as $t){
						$atag[]=['id'=>$t->tag_id,'text'=>$t->code];
					}
				}
			}
		}

		return ["results"=>$atag, "more"=>false];
	}

}

<?php namespace App\Http\Controllers\Sandbox;

use App\Language;
use DB;
use App\Tag;
use App\Tag_language;
use App\Category;
use App\Category_language;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class Sb2Controller extends Controller {

	
	public function index(){
		$atagcats=DB::table('az_tag_category')->get();
		foreach($atagcats as $atagcat){
			$atag=DB::table('az_tag')->where('id','=',$atagcat->tag_id)->get();
			$tag=Tag::where('code','=',$atag[0]->tag)->get();

			$acategory=DB::table('az_category')->where('id','=',$atagcat->category_id)->get();
			//$category=Category::where('name','=',$acategory[0]->english)->get();

			if(isset($tag->id))var_dump($tag->id);
			else var_dump($atag[0]->tag);
		}
		/*
		$atags=Tag::all();			
		foreach($atags as $atag){
			$tag=DB::table('az_tag')->where('tag','=',$atag->code)->get();

			$oTag_lg=Tag_language::firstOrCreate(['tag_id'=>$atag->id,'language_id'=>12]);
			$oTag_lg->code=$tag[0]->malay;
			$oTag_lg->save();

			$oTag_lg=Tag_language::firstOrCreate(['tag_id'=>$atag->id,'language_id'=>284]);
			$oTag_lg->code=$tag[0]->chinesejt;
			$oTag_lg->save();

			$oTag_lg=Tag_language::firstOrCreate(['tag_id'=>$atag->id,'language_id'=>285]);
			$oTag_lg->code=$tag[0]->chineseft;
			$oTag_lg->save();

		}
		
		$acategories=Category::all();			
		foreach($acategories as $acategory){
			$category=DB::table('az_category')->where('english','=',$acategory->name)->get();

			$oCat_lg=Category_language::firstOrCreate(['category_id'=>$acategory->id,'language_id'=>12]);
			$oCat_lg->name=$category[0]->malay;
			$oCat_lg->save();

			$oCat_lg=Category_language::firstOrCreate(['category_id'=>$acategory->id,'language_id'=>284]);
			$oCat_lg->name=$category[0]->chinesejt;
			$oCat_lg->save();

			$oCat_lg=Category_language::firstOrCreate(['category_id'=>$acategory->id,'language_id'=>285]);
			$oCat_lg->name=$category[0]->chineseft;
			$oCat_lg->save();

		}
		
		$acategories=DB::table('az_category')->orderBy('level')->get();
		$aparent=array();
		foreach($acategories as $acategory){
			if($acategory->level<=2){
				$category=Category::create(['name'=>$acategory->english,'level'=>$acategory->level,'seqno'=>$acategory->seqno]);
				$aparent[$acategory->id]=$category->id;
				$category->parent_id=$aparent[$acategory->parent_id];
				$category->save();
			}
		}
		*/

	}

}

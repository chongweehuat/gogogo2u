<?php namespace App\Http\Controllers\Admin;

use App\Language;
use App\Translation;
use App\Tran_language;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SetupController extends Controller {

	public function getLocales(){
		$active=Language::supportedLocales();
		return var_export($active,1);
	}

	public function getTranslate(){
		$languages=Language::where('active','=','1')->get();
		$translations=Translation::all();
		foreach($translations as $translation){
			$tcount=Tran_language::where('translation_id','=',$translation->id)
				->where('content','<>','')
				->count();
			
			$translation->tcount=$tcount;
			$translation->save();
			
			foreach($languages as $language){	
				Tran_language::firstOrCreate(array(
					'translation_id' => $translation->id,
					'language_id'=>$language->id
					));
			}
		}
		return Tran_language::count();
	}

	public function getGenlocales(){
		$languages=Language::where('active','=','1')->get();
		$translations=Translation::all();
		$afn=array();
		foreach($languages as $language){			
			foreach($translations as $translation){
				$fn='../resources/lang/'.$language->code.'/'.$translation->module.'.php';
				$afn[$fn]=1;				
			}
		}
		foreach($afn as $fn=>$v){
			file_put_contents($fn,"<?php".chr(10)."return [".chr(10));
		}
		foreach($languages as $language){			
			foreach($translations as $translation){
				$fn='../resources/lang/'.$language->code.'/'.$translation->module.'.php';
				$arows=DB::table('tran_language')
			    ->select('tran_language.content')
				->where('language_id','=',$language->id)
				->where('translation_id','=',$translation->id)
				->where('content','<>','')
				->get();
				if($arows){
					$content=$arows[0]->content;
					file_put_contents($fn,"'".$translation->code."' => ".'"'.$content.'",'.chr(10),FILE_APPEND | LOCK_EX);
				}
			}
		}
		foreach($afn as $fn=>$v){
			file_put_contents($fn,"];".chr(10)."?>",FILE_APPEND | LOCK_EX);			
		}
		return Tran_language::count();
	}

}

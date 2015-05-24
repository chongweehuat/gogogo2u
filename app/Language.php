<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Config;

class Language extends Model {

	public function tran_language()
    {
        return $this->hasMany('App\tran_language');
    }

	public static function activelist(){
		$a=Config::get('localization.supportedLocales');
		$b=array();
		foreach($a as $k=>$v){
			$b[$k]=$v['native'];
		}
		return $b;
	}

	public static function activeid(){
		$a=Config::get('localization.supportedLocales');
		$b=array();
		foreach($a as $k=>$v){
			$l=Language::where('code','=',$k)->get();
			$id=$l[0]->id;
			$b[$id]=$v['native'];
		}
		return $b;
	}

	public static function supportedLocales(){
		$actives=Language::where('active','=','1')->get();
		$aresult=array();
		foreach($actives as $k=>$v){
			$aresult[$v['code']]=array('name'=>$v['name'],'script'=>$v['script'],'native'=>$v['native']);
		}
		return $aresult;
	}

}

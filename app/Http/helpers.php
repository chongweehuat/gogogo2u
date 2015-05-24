<?php
use App\Translation;
use App\Language;

function app_init(){	
	if (!Session::has('gps.id'))App\Gps::manage();
	if (!Session::has('search.mode'))App\Tag::manage();

	$sw=Input::get('sw');
	if($sw)setcookie( 'sw', $sw, strtotime( '+365 days' ),'/' );
	$sh=Input::get('sh');
	if($sh)setcookie( 'sh', $sh, strtotime( '+365 days' ),'/' );

	$language = Input::get('lg');
	if($language){
		setcookie( 'language', $language, strtotime( '+365 days' ),'/' );
		App::setLocale($language);
	}else{
		if(isset($_COOKIE['language'])){
			$language=$_COOKIE['language'];
			if($language){
				App::setLocale($language);
			}
		}
	}	
}

function screen_size($mode='w'){
	if($mode=='w'){
		if(isset($_COOKIE['sw']))return $_COOKIE['sw'];
		else return 0;
	}elseif($mode=='h'){
		if(isset($_COOKIE['sh']))return $_COOKIE['sh'];
		else return 0;
	}else{
		if(isset($_COOKIE['sw']) and isset($_COOKIE['sh'])){
			return $_COOKIE['sw']/$_COOKIE['sh'];
		}else{
			return 0;
		}
	}
}

function update_session(){
	$lg=App::getLocale();

	if (!Session::has('search.language_id') or $lg<>Session::get('search.locale')){
		$language=Language::where('code','=',$lg)->get();
		Session::put('search.language_id',$language[0]->id);
	}
	if (!Session::has('search.locale') or $lg<>Session::get('search.locale')){			
		Session::put('search.locale',$lg);
	}
}

function trns($id = null, $parameters = array(), $domain = 'messages', $locale = null){	
	if(env('TRANSLATION_CHECK', false)){
		$c=explode('.',$id);
		Translation::firstOrCreate(array('module' => $c[0],'code'=>$c[1]));
	}
	return trans($id, $parameters, $domain, $locale);
}

?>
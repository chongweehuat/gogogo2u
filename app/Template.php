<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model {
	public static function listid(){
		$templates=Template::all();
		$a=array(0=>'Select Template');
		foreach($templates as $template){
			$a[$template->id]=$template->title;
		}
		return $a;
	}
}

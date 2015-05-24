<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Input;
use App\Tag;

use Illuminate\Http\Request;

class SearchController extends Controller {

	public function index()
	{
		$input = Input::all();
		Tag::saveinput($input);
		if(isset($input['category_id'])){
			return redirect('/');
		}else{
			$html='<pre>'.var_export($input,1);//.'<br><br>'.var_export(Session::all(),1).'</pre>';
			return view("search.business",compact("html"));
		}
	}

}

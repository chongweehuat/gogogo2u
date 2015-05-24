<?php namespace App\Http\Controllers;

use Input;

use App\Tag;
use App\Image;
use App\Album;
use App\Business;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ApiController extends Controller {

	public function index($code='')
	{
		if($code=='checkscreen')return screen_size('w').' / '.screen_size('h').' / '.screen_size('r');
		elseif($code=='selecttag')return Tag::select2(Input::get('q'));
		elseif($code=='subpageimage'){
			$html='<a href="/dashboard/uploadimages/?album_id=';
			$html.=Business::get('subpages.album_id');
			$html.='"><img src="';
			$html.=Image::url(Album::find(Business::get('subpages.album_id'))->image_id);
			$html.='" style="max-width:300px;"></a>';
			return $html;
		}
	}
}

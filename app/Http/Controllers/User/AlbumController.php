<?php namespace App\Http\Controllers\User;

use Auth;
use Input;

use App\Album;
use App\Image;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;

class AlbumController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{ 
		$tlist=Album::linklist();

		if($tlist)return view('user.managealbum',compact('tlist'));
		else return redirect('/dashboard/uploadimages');
	}
	
	public function uploadimages()
	{ 
		$album_id=Input::get('album_id');
		if(empty($album_id))$album_id=0;
		$tlist=Album::albumthumbnaillist($album_id);
		return view('user.uploadimages',compact('tlist'));
	}

	public function manageimage()
	{ 
		$image_id=Input::get('image_id');
		$movetoalbum=Input::get('movetoalbum');
		if($movetoalbum and $image_id){
			$image=Image::find($image_id);

			$album=Album::find($image->album_id);
			$album->imagecount=$album->imagecount-1;
			if($album->image_id==$image_id)$album->image_id=0;
			$album->save();

			$album=Album::find($movetoalbum);
			$album->imagecount=$album->imagecount+1;
			$album->save();

			$image->album_id=$movetoalbum;
			$image->save();
			return redirect("/dashboard/uploadimages/?album_id=$movetoalbum");
		}

		$description=Input::get('description');
		if($description and $image_id){
			$image=Image::find($image_id);
			$image->description=$description;
			$image->save();
		}		
		
		$tlist=Album::albumimage($image_id);
		if($tlist['id']){
			$removeimage=Input::get('removeimage');
			if($removeimage==$image_id){
				$image=Image::find($image_id);

				$album=Album::find($image->album_id);
				$album->imagecount=$album->imagecount-1;
				if($album->image_id==$image_id)$album->image_id=0;
				$album->save();

				$image->delete();
				return redirect("/dashboard/uploadimages/?album_id={$image->album_id}");
			}
		}

		return view('user.manageimage',compact('tlist'));
	}
	
	public function add() {		
		$album_id=Input::get('album_id');
		$description=Input::get('description');
		$image_id=Input::get('image_id');
		$fdescription=Input::get('fdescription');
		$files = Request::file('images');
		if(empty($image_id))$image_id=0;
		$album_id=Image::saveupload($album_id,$description,$image_id,$fdescription,$files);
		 
		return redirect("/dashboard/uploadimages/?album_id=$album_id");
	}	
}

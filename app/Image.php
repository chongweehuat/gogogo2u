<?php namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Album;

class Image extends Model {

	public static function fnprefix($id){
		$a=str_split($id);
		$s=array();
		foreach($a as $k=>$v){
			if(!($k%2))$s[]='/';
			$s[]=$v;
		}
		return implode('',$s);
	}

	public static function fn($id){
		$image=Image::find($id);
		return self::fnprefix($id).$image->filename;
	}

	public static function url($id){
		return 'http://bizinfoimg.com'.self::fn($id);
	}
	
	public static function select($table='mainpages'){
		$wechat_image_id=Business::get($table.'.wechat_image_id');		
		$currentUser = Auth::user();
		$albums=Album::where('user_id','=',$currentUser->id)->where('image_id','>',0)->get();
		$html='<select id="wechat_image_id" name="fn['.$table.'.wechat_image_id]" class="form-control">';
		$html.="<option value=0>select image</option>";
		foreach($albums as $album){
			$selected='';
			if($album->image_id==$wechat_image_id)$selected='SELECTED';
			$html.="<option value={$album->image_id} $selected>{$album->description}</option>";
		}
		$html.='</select>';
		return $html;
	}

	public static function saveupload($album_id,$description,$image_id,$fdescription,$files){
		if(empty($album_id)){
			$currentUser = Auth::user();
			$album=Album::Create(['user_id'=>$currentUser->id]);
		}else{
			$album=Album::find($album_id);
		}
		$album->description=$description;
		$album->image_id=$image_id;
		$album->save();

		if($fdescription){
			foreach($fdescription as $k=>$v){
				$image=Image::find($k);
				$image->description=$v;
				$image->save();
			}
		}

		foreach($files as $file){
			if($file){
				$extension = $file->getClientOriginalExtension();			
				$entry = new Image();
				$entry->album_id=$album->id;
				$entry->mime = $file->getClientMimeType();
				$entry->original_filename = $file->getClientOriginalName();
				$entry->filename = $file->getFilename().'.'.$extension;		 
				$entry->save();
				
				$saved=Storage::disk('s3')->put(Image::fn($entry->id),File::get($file));
				if($saved){
					$entry->imgurl=Image::url($entry->id);
					$entry->save();
		
					$album->imagecount=$album->imagecount+1;
					if(empty($album->image_id)){					
						$album->image_id=$entry->id;					
					}
					$album->save();
				}
			}
		}
		
		return $album->id;
	}

}

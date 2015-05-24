<?php namespace App;

use Auth;
use Session;
use App\Business;
use Illuminate\Database\Eloquent\Model;

class Album extends Model {

	protected $fillable = ['user_id','image_id','description'];

	public static function select($table='mainpages'){
		$album_id=Business::get($table.'.album_id');		
		$currentUser = Auth::user();
		$albums=Album::where('user_id','=',$currentUser->id)->get();
		$html='<select id="album" name="fn['.$table.'.album_id]" class="form-control">';
		$html.="<option value=0>select album</option>";
		foreach($albums as $album){
			$selected='';
			if($album->id==$album_id)$selected='SELECTED';
			$html.="<option value={$album->id} $selected>{$album->description} ({$album->imagecount})</option>";
		}
		$html.='</select>';
		return $html;
	}

	public static function linklist(){
		$currentUser = Auth::user();
		$album=Album::where('user_id','=',$currentUser->id)->get();
		if(count($album)){
			$html="<div style='margin-left:10px;margin-right:10px;'>";
			foreach($album as $v){
				$html.="<div style='float:left;'>";

				$html.="<div style='margin:10px 10px 10px 10px; width:180px;height:350px;'>";
				$html.="<a href=/dashboard/uploadimages/?album_id={$v->id}>";				
				if($v->image_id){
					$image=Image::find($v->image_id);
					if(isset($image->imgurl) and $image->imgurl){
						$html.="<img src={$image->imgurl} style='max-width:180px;'>";
					}
				}
				$html.='<center>'.$v->description." ({$v->imagecount})</center>";
				$html.="</a> ";
				$html.="</div>";

				$html.="</div>";
				if(empty($v->imagecount)){
					$o=Album::find($v->id);
					$o->imagecount=Image::where('album_id','=',$v->id)->count();
					$o->save();
				}
			}
			$html.="</div>";
			return $html;
		}else{
			return '';
		}
	}

	public static function albumimage($image_id){
		$html='';
		$image=Image::find($image_id);
		if(isset($image->album_id) and $image->album_id){
			$album=Album::find($image->album_id);
			$currentUser = Auth::user();
			if(isset($album->user_id) and $album->user_id==$currentUser->id){
				$albums=Album::where('user_id','=',$currentUser->id)->where('id','<>',$image->album_id)->get();
				if(count($albums)){
					$html.="<form method=get>";
					$html.='<input type="hidden" name="_token" value="'.csrf_token().'">';
					$html.='<input type="hidden" name="image_id" value="'.$image_id.'">';
					$html.="<select name=movetoalbum onchange=submit()>";
					$html.="<option value={$album->id}>Move To Other Album</option>";
					foreach($albums as $album){
						$html.="<option value={$album->id}>{$album->description} ({$album->imagecount})</option>";
					}
					$html.='</select>';
					$html.="&nbsp;&nbsp;&nbsp;&nbsp;<a href=?image_id=$image_id&removeimage=$image_id onclick=\"return confirm('Sure to delete image?')\">Remove Image</a>";
					$html.='</form><br>';
					$html.="<form method=get>";
					$html.='<input type="hidden" name="_token" value="'.csrf_token().'">';
					$html.='<input type="hidden" name="image_id" value="'.$image_id.'">';
					$html.="Description<br><input type=text name=description value=\"{$image->description}\" size=60 onchange=submit()>";					
					$html.='</form><br>';
				}
				$html.="<img src='{$image->imgurl}'>";
			}
			return ['id'=>$image->album_id,'html'=>$html];
		}
		return ['id'=>0,'html'=>''];
	}

	public static function albumthumbnaillist($album_id){
		if($album_id){
			$album=Album::find($album_id);
			$description=$album->description;
			$image_id=$album->image_id;
		}else{
			$description='';
			$image_id=0;
		}

		$html="<div style='width:100%;'>";
		$html.="<input type=hidden name=album_id value=$album_id>";
		$html.="<div style='text-align:center;margin-top:20px;margin-bottom:20px;'>Album Description: <input type=text name=description value=\"$description\" size=40></div>";

		$arows=Image::where('album_id','=',$album_id)
			->where('imgurl','<>','')
			->orderby('id','desc')			
			->get();
		
		$html.="<div style='margin-left:10px;margin-right:10px;'>";
		foreach($arows as $arow){
			if(empty($image_id)){
				$image_id=$arow['id'];
				$album->image_id=$image_id;
				$album->save();
			}
			$checked='';
			if($image_id==$arow['id'])$checked='CHECKED';
			$html.="<div style='margin:10px 10px 10px 10px;float:left;width:180px;height:300px;'>";
			$html.="<div>";
			$html.="<a href='/dashboard/manageimage/?image_id={$arow['id']}'><img src='{$arow['imgurl']}' style='max-width:180px;'></a>";
			$html.="</div>";
			$html.="<div>";
			$html.="<input type=text name=fdescription[{$arow['id']}] value=\"{$arow['description']}\" size=20> ";
			$html.="<input type=radio name=image_id value={$arow['id']} $checked title='Set As Album Image'>";
			$html.="</div>";
			$html.="</div>";
		}
		$html.="</div>";
		$html.="</div>";
		return $html;
	}

}

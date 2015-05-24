<?php namespace App\Http\Controllers\Admin;

use App\Webpage;
use App\Translation;
use App\Tran_language;
use App\Tag;
use App\Category;
use App\Tag_category;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use Zofe\Rapyd\Facades\DataSet;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataFilter;

class AdminController extends Controller {

public function __construct()
	{
		$this->middleware('auth');
	}

public function getMenu()
	{
		return  View::make('admin.menu');
	}

public function anyWebpage($code='datagrid')
    {
		$filter='';
		if($code=='datagrid'){
			$grid = DataGrid::source(new Webpage());

			$grid->add('id','ID', true)->style("width:100px");
			$grid->add('title','Title');
			$grid->add('{{ str_limit($body,4) }}','Body');

			$grid->edit('/admin/webpage/edit', 'Edit','show|modify');
			$grid->link('/admin/webpage/edit',"New Webpage", "TR");
			$grid->orderBy('id','desc');
			$grid->paginate(10);

			$grid->row(function ($row) {
			   if ($row->cell('id')->value == 20) {
				   $row->style("background-color:#CCFF66");
			   } elseif ($row->cell('id')->value > 15) {
				   $row->cell('title')->style("font-weight:bold");
				   $row->style("color:#f00");
			   }
			});

			$data=$grid;
		}elseif($code=='edit'){
			if (Input::get('do_delete')==1) return  "not the first";

			$edit = DataEdit::source(new Webpage());
			//$edit->label('Edit Webpage');
			$edit->link("admin/webpage/filter","Webpages", "TR")->back();
			$edit->add('title','Title', 'text')->rule('required|min:5');

			$edit->add('body','Body', 'redactor');

			$data=$edit;
		}elseif($code=='filter'){
			$filter = DataFilter::source(new Webpage());
			$filter->add('title','Title', 'text');
			$filter->submit('search');
			$filter->reset('reset');
			$filter->build();

			$grid = DataGrid::source($filter);
			$grid->attributes(array("class"=>"table table-striped"));
			$grid->add('id','ID', true)->style("width:70px");
			$grid->add('title','Title', true);
			$grid->add('body|strip_tags|substr[0,20]','Body');
			$grid->edit('/admin/webpage/edit', 'Edit','modify|delete');
			$grid->paginate(10);

			$data=$grid;
		}

		$title='Webpage';
		
        return  View::make('admin.data', compact('title','filter','data'));
    }

	public function anyTranslation($code='filter',Request $request=null)
    {
		$filter='';
		if($code=='filter'){
			$filter = DataFilter::source(new Translation());
			$filter->add('code','Code', 'text');
			$filter->submit('search');
			$filter->reset('reset');
			$filter->build();

			$grid = DataGrid::source($filter);
			$grid->attributes(array("class"=>"table table-striped"));
			$grid->add('module','Module');
			$grid->add('code','Code');
			$grid->add('tcount','Count', true);
			$grid->edit('/admin/translation/edit', 'Edit','modify');
			$grid->paginate(100);

			$data=$grid;
		}elseif($code=='edit'){
			$afd=$request->input('fd');
			if($afd){
				foreach($afd as $id=>$v){
					$tl=Tran_language::find($id);
					$tl->content=$v;
					$tl->save();
				}
			}

			$id=$request->input('modify');
			$tcount=Tran_language::where('translation_id','=',$id)
				->where('content','<>','')
				->count();
			$translation=Translation::find($id);
			$translation->tcount=$tcount;
			$translation->save();

			$arows=DB::table('tran_language')
	            ->join('translations', 'translations.id', '=', 'tran_language.translation_id')
		        ->join('languages', 'languages.id', '=', 'tran_language.language_id')				
			    ->select('tran_language.id','tran_language.content', 'translations.module', 'translations.code','languages.native')
				->where('tran_language.translation_id','=',$id)
				->get();

			$filter='<a href=/admin/translation/filter >Back</a><br><br>';
			$filter.=$arows[0]->module.' > '.$arows[0]->code;

			$html="<br><center><table><form method=post>";
			$html.='<input type="hidden" name="_token" value="'.csrf_token().'">';
			foreach($arows as $arow){
				$html.="<tr><td>{$arow->native}:</td>";
				$html.="<td><input type=text name=fd[{$arow->id}] value=\"{$arow->content}\" size=100></td></tr>";
			}			
			$html.="<tr><td colspan=2 align=center><br><input type=submit value=Save></td></tr>";
			$html.="</form></table></center>";
			
			$data=$html;
		}

		$title='Translation';
		
        return  View::make('admin.data', compact('title','filter','data'));
    }

	public function anyTags($code='filter',Request $request=null)
    {
		$filter='';
		if($code=='filter'){
			$filter = DataFilter::source(Tag::with('categories'));
			$filter->add('code','Code', 'text');
			$filter->submit('search');
			$filter->reset('reset');
			$filter->build();

			$grid = DataGrid::source($filter);
			$grid->attributes(array("class"=>"table table-striped"));
			$grid->add('code','Code');
			$grid->add('ncount','View Count', true);
			$grid->add('branded','Branded');
			$grid->add('user_id','User ID');
			$grid->edit('/admin/tags/edit', 'Edit','modify');
			$grid->paginate(10);

			$data=$grid;
		}elseif($code=='edit'){
			$id=$request->input('modify');

			$afd=$request->input('fd');
			if($afd){
				DB::table('tag_categories')->where('tag_id','=',$id)->delete();
				foreach($afd as $k=>$v){					
					Tag_category::create(['tag_id'=>$id,'category_id'=>$k]);
				}
			}
			
			$tag=Tag::find($id);
			$filter='<a href=/admin/tags/filter>Back</a><h2>'.$tag->code.'</h2>';

			$categories=DB::table('categories')->where('level','>',0)->orderBy('seqno')->get();
			$html="<br><center><form method=post>";
			$html.='<input type=submit value=Save>';
			$html.='<table>';
			$html.='<input type="hidden" name="_token" value="'.csrf_token().'">';
			foreach($categories as $category){
				$html.='<tr><td>';
				$html.=str_repeat('&nbsp;',$category->level*6);
				$tag_cat=Tag_category::where('tag_id','=',$id)->where('category_id','=',$category->id)->get();
				if(isset($tag_cat[0]))$checked='CHECKED';
				else $checked='';
				$html.="<input type=checkbox name=fd[$category->id] value=1 $checked> ";
				if($checked)$html.='<span style="color:red;font-size:150%;">';
				$html.=$category->name;
				if($checked)$html.='</span>';
				$html.='</td></tr>';
			}
			$html.='</table>';
			$html.='</form>';
			$html.='</center>';

			$data=$html;
		}

		$title='Tags';
		
        return  View::make('admin.data', compact('title','filter','data'));
    }
}
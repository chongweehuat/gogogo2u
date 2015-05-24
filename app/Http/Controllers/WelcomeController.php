<?php namespace App\Http\Controllers;

use Zofe\Rapyd\Facades\DataGrid;
use Illuminate\Support\Facades\View;
use App\Webpage;

class WelcomeController extends Controller {
	
	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */	 
	public function index()
	{			
		$grid = DataGrid::source(new Webpage);
		$grid->add('title','Title');
		$grid->add('{{ str_limit($body,4) }}','Body');
		$grid->paginate(10);

        $grid->row(function ($row) {
           if ($row->cell('id')->value == 20) {
               $row->style("background-color:#CCFF66");
           } elseif ($row->cell('id')->value > 15) {
               $row->cell('title')->style("font-weight:bold");
               $row->style("color:#f00");
           }
        });

		return View::make('welcome', compact('grid'));
	}

}

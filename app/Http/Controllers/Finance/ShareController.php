<?php namespace App\Http\Controllers\Finance;

use Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ShareController extends Controller {

	public function getSina()
	{
		return file_get_contents('http://finance.sina.com.cn/realstock/company/sz000702/nc.shtml');
	}	
}

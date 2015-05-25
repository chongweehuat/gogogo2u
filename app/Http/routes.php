<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

app_init();

Route::get('test',function(){
	//return phpinfo();
	//return App\Zstock::similar('sz000553');
	return App\Zstock::analytic();
	//return App\Zstock::updatechanges();
	//return App\Zstock::updatelatest();
	//return App\Zstock::importhistory();

	//App\Event::savetag(array('0'=>'test','1'=>20));
	//return App\Tag::select2('陈');
	//return screen_size('w').' / '.screen_size('h').' / '.screen_size('r');
	//return App\Template::listid();
	//return App\Business::updatefn(array('subpages.body'=>'subpage body'));
	//return App\Business::get('gps.latlng');
	//App\Business_domain::savedomain('go32u.com');
	//App\Business_code::savecode('go32u');
	//return App\Business::get('table.code');
	//return App\Business::updatefn(['table.code'=>'xxxxx']);
	//return Session::all();
});

Route::get('sb2', 'Sandbox\Sb2Controller@index');

Route::get('/', 'Go32uController@index');

Route::get('search','SearchController@index');
Route::post('search',['as' => 'tagsearch', 'uses' => 'SearchController@index']);

Route::get('gps', 'GpsController@index');
Route::post('gps',['as' => 'gpslocation', 'uses' => 'GpsController@index']);

Route::get('page/{code}', 'PageController@index');

Route::get('home', 'HomeController@index');

Route::get('/api/{code}', 'ApiController@index');

//Route::get('admin', 'Admin\AdminController@getmenu');

Route::get('admin', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'Admin\AdminController@getmenu',
	'roles' => ['administrator', 'manager', 'user'] // Only an administrator, or a manager can access this route
]);

Route::controllers([
	'provider' => 'Auth\ProviderController',
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
	'admin'=> 'Admin\AdminController',
	'setup'=> 'Admin\SetupController',
	'finance'=> 'Finance\ShareController',
]);

Route::get('/dashboard/album', 'User\AlbumController@index');
Route::get('/dashboard/uploadimages', 'User\AlbumController@uploadimages');
Route::get('/dashboard/manageimage', 'User\AlbumController@manageimage');
Route::post('/dashboard/uploadimages',[
        'as' => 'uploadimages', 'uses' => 'User\AlbumController@add']);

Route::get('/dashboard/business', 'User\BusinessController@index');
Route::get('/dashboard/business/{code}', 'User\BusinessController@gethtml');
Route::get('/dashboard/managebusiness', 'User\BusinessController@manage');
Route::get('/dashboard/manageevent', 'User\BusinessController@event');
Route::get('/dashboard/updatebusiness',[
        'as' => 'managebusiness', 'uses' => 'User\BusinessController@update']);
Route::post('/dashboard/updatebusiness',[
        'as' => 'managebusiness', 'uses' => 'User\BusinessController@update']);
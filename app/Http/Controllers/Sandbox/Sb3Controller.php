<?php namespace App\Http\Controllers\Sandbox;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class Sb3Controller extends Controller {

	public function index(){
		$local_ip='';
		
		$urls="http://www.pantagraph.com/users/profile/hayescourtney/
http://www.startrek.com/view_profile/hayescourtney
http://www.sodahead.com/user/profile/4049832/courtney-m-hayes/?public=true
http://www.supermanhomepage.com/profile.php?lookup=40601
http://magicseaweed.com/user.php?id=603873
http://www.shapeways.com/designer/hayescourtney
http://www.yaliberty.org/profiles/courtney-hayes
http://www.pocketgpsworld.com/modules.php?name=Your_Account&op=userinfo&bypass=1&username=bentonchales
http://www.network54.com/Profile/hayescourtney
http://www.morguefile.com/creative/hayescourtney
http://forums.site5.com/member.php?u=350420
http://www.mobypicture.com/user/hayescourtney
http://forum.videohelp.com/members/240167-hayescourtney
http://www.metal-archives.com/users/hayescourtney
http://forum.kaltura.org/users/hayescourtney/activity
http://forums.redflagdeals.com/members/hayescourtney-1178721/
https://www.ifixit.com/User/1152749/hayescourtney
http://forums.mydigitallife.info/members/492395-hayescourtney
http://www.wmmr.com/extras/profile/index.aspx?mid=112597373
http://forum.thegradcafe.com/user/214450-hayescourtney/
http://perpustakaan.bappenas.go.id:8080/jforum/user/editDone/19233.page
http://torgi.gov.ru/forum/user/editDone/123685.page
http://qcn.stanford.edu/sensor/view_profile.php?userid=107432
http://czwlwz.chaozhou.gov.cn/JForum/user/editDone/34995.page
https://digger3head.wordpress.com/2015/03/31/why-you-need-to-invest-in-the-best-nightclubs/";
/*
		$ch = curl_init('http://indexchecking.com/');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		if($local_ip)curl_setopt($ch, CURLOPT_INTERFACE, $local_ip);

		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, array('f_urls'=>$urls));

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		$sdata=curl_exec($ch);

		curl_close($ch);

		return $sdata;
*/
return '<pre>'.var_export(self::checkresult(),1).'</pre>';
	}

	public static function checkresult(){
		$content=file_get_contents('result.html');
		$arows=explode("<tr class='rowclass",$content);
		$aurls=array();
		foreach($arows as $n=>$row){
			if($n){
				$arow=explode("href='",$row);
				$a=explode("'",$arow[1]);
				$aurl[$a[0]]=substr($row,0,1);
			}
		}
		return $aurl;
	}

}

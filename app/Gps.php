<?php namespace App;

use App\Ip_city;

use Session;

use Illuminate\Database\Eloquent\Model;

class Gps extends Model {

	protected $fillable = ['lat','lng','address','gps_address'];

	public static function manage(){
		if (!Session::has('gps.id')){
		
			if(isset($_COOKIE['gps'])){
				$gps_id=$_COOKIE['gps'];
				$oGps=Gps::find($gps_id);
				if($oGps)Session::put('gps.id', $_COOKIE['gps']);
			}else{
				Session::put('gps.id',Ip_city::ip_gps_id());
			}

		}
		$oGps=Gps::find(Session::get('gps.id'));
		if($oGps){
			Session::put('gps.lat',$oGps->lat);
			Session::put('gps.lng',$oGps->lng);
			Session::put('gps.address',$oGps->address);
			Session::put('gps.gps_address',$oGps->gps_address);
		}
	}
	
	public static function updatebyaddress($address){
		$a=explode(',',$address);
		if(count($a)>1 and is_numeric(trim($a[0])) and is_numeric(trim($a[1])) ){
			$lat=number_format(trim($a[0]),4);
			$lng=number_format(trim($a[1]),4);
			$oGps=Gps::where('lat','=',$lat)->where('lng','=',$lng)->get();
			if(isset($oGps->id)){
				Session::put('gps.id',$oGps->id);
			}else{
				$gps_id=Gps::getlocationgpsid($lat,$lng);
				if($gps_id){
					Session::put('gps.id',$gps_id);				
				}
			}
		}else{
			$gps_id=Gps::getaddressgpsid($address);
			if($gps_id){
				Session::put('gps.id',$gps_id);				
			}
		}
		setcookie( 'gps', Session::get('gps.id'), strtotime( '+365 days' ),'/' );
		Gps::manage();
	}

	public static function getlocationgpsid($lat,$lng){
		$lat=number_format(trim($lat),4);
		$lng=number_format(trim($lng),4);
		$oGps=Gps::where('lat','=',$lat)->where('lng','=',$lng)->get();
		if(isset($oGps->id))return $oGps->id;

		$result=self::getipcontents("https://maps.googleapis.com/maps/api/geocode/json?sensor=false&latlng=$lat,$lng");
		$a=explode('"formatted_address" :',$result);
		if(count($a)>1){
			$a=explode('"geometry"',$a[1]);
			$a=explode('"',$a[0]);
			$address=$a[1];
		}else{
			$address='';
		}

		if($address){
			$oGps=Gps::firstOrCreate(['lat'=>$lat,'lng'=>$lng]);
			$oGps->lat=$lat;
			$oGps->lng=$lng;
			$oGps->address=$address;
			$oGps->gps_address=$address;
			$oGps->save();

			return $oGps->id;

		}else return 0;
	}

	public static function getaddressgpsid($address){
		
		$address=trim($address);
		$address255=substr($address,0,255);
		$oGps=Gps::where('address','=',$address255)->get();
		if(isset($oGps->id))return $oGps->id;

		$result=self::getipcontents("http://maps.google.com/maps/api/geocode/json?sensor=false&address=".urlencode($address));
		$a=explode('"location" :',$result);
		if(count($a)>=2){
			$a=explode('"location_type"',$a[1]);
			$s=str_replace('"lat" :','',$a[0]);
			$s=str_replace('"lng" :','',$s);
			$s=str_replace('"lng" :','',$s);
			$s=str_replace('{','',$s);
			$s=str_replace('}','',$s);
			$a=explode(',',$s);

			$b=explode('"formatted_address" :',$result);
			$b=explode('"geometry"',$b[1]);
			$b=explode('"',$b[0]);
		}

		if(count($a)>=2){
			$lat=number_format(trim($a[0]),4);
			$lng=number_format(trim($a[1]),4);
			$oGps=Gps::firstOrCreate(['lat'=>$lat,'lng'=>$lng]);
			$oGps->address=$address255;
			$oGps->gps_address=$b[1];
			$oGps->save();

			return $oGps->id;
			
		}else{			
			return 0;
		}
	}


	public static function getipcontents($url){
		$aip=array(
			
		);
		if($aip){
			$n=rand(0,count($aip)-1);
			$local_ip=$aip[$n];
			return self::geturlcontents($url,$local_ip);
		}else return self::geturlcontents($url);
	}

	public static function geturlcontents($url,$local_ip=''){

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		if($local_ip)curl_setopt($ch, CURLOPT_INTERFACE, $local_ip);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT,self::useragent());
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		$result=curl_exec($ch);
		curl_close($ch);			
		return $result;
	}

	public static function useragent(){
		$auseragent=array(
			'Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)',
			'Mozilla/5.0 (compatible; Konqueror/3.92; Microsoft Windows) KHTML/3.92.0 (like Gecko)',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; WOW64; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; Media Center PC 5.0; .NET CLR 1.1.4322; Windows-Media-Player/10.00.00.3990; InfoPath.2',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; Dealio Deskball 3.0)',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; NeosBrowser; .NET CLR 1.1.4322; .NET CLR 2.0.50727)',
			'Opera/9.64(Windows NT 5.1; U; en) Presto/2.1.1',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.50',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)',
			'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/532.2 (KHTML, like Gecko) Chrome/4.0.221.7 Safari/532.2',
			'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-GB; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3 (.NET CLR 3.5.30729)',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.14) Gecko/2009082707 Firefox/3.0.14 (.NET CLR 3.5.30729)',
			'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; Media Center PC 6.0; InfoPath.2; MS-RTC LM 8)',
			'Mozilla/5.0 (X11; U; Linux i686; it-IT; rv:1.9.0.2) Gecko/2008092313 Ubuntu/9.25 (jaunty) Firefox/3.8',
		);
		$n=rand(0,count($auseragent)-1);
		return $auseragent[$n];
	}

	public static function googlemapbyid($id){
		$gps=Gps::find($id);
		return Gps::googlemap($gps->lat,$gps->lng);
	}

	public static function googlemap($lat,$lng){
		$html="<a href='http://maps.google.com/maps?q={$lat},{$lng}' target=_blank><strong>".trns('general.googlemap')."</strong></a>";		
		return $html;
	}

	public static function waze($lat,$lng){
		$html="<a href='waze://?ll={$lat},{$lng}&navigate=yes' target=_blank><strong>".trns('general.waze')."</strong></a>";		
		return $html;
	}
}

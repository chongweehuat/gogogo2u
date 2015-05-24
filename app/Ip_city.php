<?php namespace App;

use App\Gps;

use Illuminate\Database\Eloquent\Model;

class Ip_city extends Model {

	protected $table = 'ip_cities';

	protected $fillable = ['ip','city','gps_id'];

	public static function ip_gps_id(){
		$oIp=Ip_city::firstOrCreate(['ip' => $_SERVER['REMOTE_ADDR']]);
		if(empty($oIp->city)){
			$oIp->city=self::getipcity($oIp->ip);
			$oIp->gps_id=Gps::getaddressgpsid($oIp->city);
			$oIp->save();
		}
		if(empty($oIp->gps_id)){
			$oIp->gps_id=Gps::getaddressgpsid($oIp->city);
			$oIp->save();
		}
		return Gps::getaddressgpsid($oIp->city);
	}

	public static function getipcity($ip){
		$url="http://api.db-ip.com/addrinfo?addr=$ip&api_key=2d6eeed6e89858855ea555d8e0cb90d3a50e7c0e&";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$output = curl_exec($ch);		

		curl_close($ch);

		$result=json_decode($output);
		$city=$result->city;
		if(empty($city))$city='unknown';

		return $city;
	}

}

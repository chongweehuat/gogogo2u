<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tran_language extends Model {

	protected $table = 'tran_language';

	protected $fillable = ['translation_id','language_id','content'];

	public function translation()
	{
		return $this->belongsTo('App\Translation');
	}

	public function language()
	{
		return $this->belongsTo('App\Language');
	}

}

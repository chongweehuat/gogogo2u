<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model {

	protected $fillable = ['module', 'code'];

	public function tran_language()
    {
        return $this->hasMany('App\tran_language');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOauth extends Model {

	protected $table = 'users_oauth';
	protected $fillable = ['provider', 'provider_user_id', 'user_id'];
	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('App\User');
	}

}
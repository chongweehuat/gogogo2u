<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag_category extends Model {

	protected $fillable = ['tag_id','category_id'];

	public function categories()
    {
		return $this->belongsTo('App\Category', 'category_id');
	}
}

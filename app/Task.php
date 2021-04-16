<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
	protected $guarded = [];
//	protected $fillable = ['title','completed'];

	// Eloquent with user
	public function user(){
		return $this->belongsTo( User::class);
	}


}

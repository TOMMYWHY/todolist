<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable {
	use Notifiable;

	// uuid replace id
	public $incrementing = false;

	protected static function boot() {
		parent::boot();
		static:: creating( function ( $model ) {
			$model->{$model->getKeyName()} = (string) Str::uuid();
		} );
	}

	//Eloquent with task
	public function tasks() {
		return $this->hasMany( Task::class );
	}

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];
}

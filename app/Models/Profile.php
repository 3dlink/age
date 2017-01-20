<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

	/**
	 * Fillable fields for a Profile
	 *
	 * @var array
	 */
	protected $fillable = [
		'bio',
		'phone',
		'skype_user',
		'profile_pic'
	];

	/**
	 * A profile belongs to a user
	 *
	 * @return mixed
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

}
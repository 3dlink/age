<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // USER ROLES
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function client()
    {
    	return $this->belongsTo('App\Models\User', 'client_id');
    }
}

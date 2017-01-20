<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'uploaded_by');
    }

    public function client(){
    	return $this->belongsTo('App\Models\User', 'belongs_to');
    }
}

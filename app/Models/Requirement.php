<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public function creator(){
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function analyst(){
        return $this->belongsTo('App\Models\User', 'assigned_to');
    }

    public function subject()
    {
		return $this->belongsTo('App\Models\Subject');
    }

    public function priority()
    {
        return $this->belongsTo('App\Models\Priority');
    }
}

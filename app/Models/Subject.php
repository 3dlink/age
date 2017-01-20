<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function priorities()
    {
        return $this->belongsToMany('App\Models\Priority', 'subject_priority');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    public function subjects()
    {
        return $this->belongsToMany('App\Models\Subject', 'subject_priority');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function Schedule(){
        return $this->belongsTo(Schedule::class);
    }
}

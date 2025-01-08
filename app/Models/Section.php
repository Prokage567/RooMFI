<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function schedule(){
        return $this->hasMany(Schedule::class);
    }
}

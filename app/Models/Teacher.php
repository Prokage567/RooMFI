<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function schedule(){
        return $this->belongsToMany(Schedule::class);
    }
    protected $fillable = [
        "name",
    ];
}

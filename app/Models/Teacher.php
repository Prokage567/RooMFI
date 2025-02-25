<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    protected $fillable = [
        "name",
        "subject"
    ];
}

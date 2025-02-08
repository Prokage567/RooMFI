<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    protected $fillable = [
        "name",
        "type"
    ];
}

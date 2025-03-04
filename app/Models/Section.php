<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        "name",
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
}

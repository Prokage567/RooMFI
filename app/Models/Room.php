<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    protected $fillable = [
        "name",
        "category_id"
    ];
    
    public $timestamps = false;
}

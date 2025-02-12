<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function room(){
        return $this->hasMany(Room::class);
    }
    protected $fillable = [
        "category"
    ];
    
    public $timestamps = false;
}

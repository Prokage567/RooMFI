<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
        "reason",
        "room_id",
        "user_id"
    ];
    public $timestamps= false;
}

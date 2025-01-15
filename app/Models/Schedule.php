<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function section()
    {
        return $this->hasOne(Section::class);
    }
    public function room()
    {
        return $this->hasOne(Room::class);
    }
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
    protected $fillable = [
        "day",
        "start_time",
        "end_time",
        "teacher_id",
        "section_id",
        "room_id",
    ];
}

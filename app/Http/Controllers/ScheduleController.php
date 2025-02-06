<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function all()
    {
        return $this->ok(Schedule::all(), "all of the Schedules! ");
    }
    public function show(Schedule $schedule)
    {
        return $this->ok($schedule, "A Schedule!");
    }
    public function store(Request $request)
    {
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $validator = validator($request->all(), [
            "day" => "required|int",
            "date" => "required|date_format:Y-m-d",
            "teacher_id" => "required|exists:teachers,id",
            "section_id" => "required|exists:sections,id",
            "room_id" => "required|exists:rooms,id"
        ]);
        if ($validator->fails()) {
            return $this->BadRequest($validator, "you have input invalid informations!");
        }
        $validated = $validator->validated();
        $Schedule = Schedule::create($validated);
        return $this->ok($validated, "Succesfully added a Schedule!");
    }
    public function update(Request $request, Schedule $schedule)
    {
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $validator = validator($request->all(), [
            "day" => "required|int",
            "date" => "required|date",
            "teacher_id" => "required|exists:teachers,id",
            "section_id" => "required|exists:sections,id",
            "room_id" => "required|exists:rooms,id"
        ]);
        if ($validator->fails()) {
            return $this->BadRequest($validator, "you have input invalid informations!");
        }
        $validated = $validator->validated();

        $schedule->update($validated);

        return $this->ok($validated, "Succesfully updated a Schedule!");
    }
    public function delete(Request $request, Schedule $schedule)
    {
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $schedule->delete();
        return $this->ok(null, "A Schedule has been deleted!");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
            "day" => "required:int",
            "subject" => "required",
            "start_time" => "required|date_format:g:i A",
            "end_time" => "required|date_format:g:i A|after:start_time",
            "start_date" => "required|date_format:Y-m-d",
            "end_date" => "required|date_format:Y-m-d",
            "teacher_id" => "required|exists:teachers,id",
            "section_id" => "required|exists:sections,id",
            "room_id" => "required|exists:rooms,id"
        ]);
        if ($validator->fails()) {
            return $this->BadRequest($validator, "you have input invalid informations!");
        }
        $validated = $validator->validated();
        $cur = Carbon::parse($validated["start_date"]);
        $last = Carbon::parse($validated["end_date"])->addDay();
        $strTime = Carbon::parse($validated["start_time"]);
        $endTime = Carbon::parse($validated["end_time"]);
        
        $validated["start_time"] = $strTime->format("g:i A");
        $validated["end_time"] = $endTime->format("g:i A");
        
        while ($cur->isBefore($last)) {
            $validated["date"] = $cur;
            Schedule::create($validated);
            $cur = $cur->addDays(7);
        }
        return $this->ok($validated, "Succesfully added a Schedule!");
    }
    public function update(Request $request, Schedule $schedule)
    {
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $validator = validator($request->all(), [
            "day" => "required",
            "subject" => "required",
            "start_time" => "required|date_format:g:i A",
            "end_time" => "required|date_format:g:i A|after:start_time",
            "start_date" => "required|date_format:Y-m-d",
            "end_date" => "required|date_format:Y-m-d",
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

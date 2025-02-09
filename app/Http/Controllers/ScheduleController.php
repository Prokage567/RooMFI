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
            "day" => "required|int",
            "time" => "required|time",
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
        //it receives the start date
        $cur = Carbon::parse($validated["start_date"]);
        //it receives the end date but at the same time it adds another day because of a conflict in the isbefore 
        //isbefore function is not an equal condition so simple solution is by adding one day
        $last = Carbon::parse($validated["end_date"])->addDay();
        //this loops until the end date was met
        while($cur->isBefore($last)){
            //adds the data from loop to the date fillable of the schedule
            $validated["date"] = $cur;
            Schedule::create($validated);
            //it adds another 7 days prior to the chosen dayof the week
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
           "day" => "required|int",
            "time" => "required|time",
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

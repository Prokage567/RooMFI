<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function search($keywords)
    {
        $keywords = array($keywords);
        $teachers = DB::table("teachers");
        foreach ($keywords as $key) {
            $teachers->select("id")->orWhereLike("name","%$key%");
        }
        return $this->ok($teachers->get(), "all Teachers!");
    }

    public function all()
    {
        $teachers = Teacher::with("schedules")->get();

        foreach ($teachers as $teacher) {
            foreach ($teacher->schedules as $schedule) {
                $schedule->room;
                $schedule->section;
                $schedule->start_time = Carbon::parse($schedule->start_time)->format("h:i A");
                $schedule->end_time = Carbon::parse($schedule->end_time)->format("h:i A");
            }
        }
        return $this->ok($teachers, "all Teachers!");
    }
    public function show(Teacher $teacher)
    {
        return $this->ok($teacher, "Teacher's name!");
    }
    public function store(Request $request)
    {
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $validator = validator($request->all(), [
            "name" => "required|string|uppercase",
            "subject" => "required|string|uppercase",
        ]);
        if ($validator->fails()) {
            return $this->BadRequest($validator, "invalid input!");
        }
        $validated = $validator->validated();

        $teacher = Teacher::create($validated);

        return $this->ok($teacher, "Teacher Added!");
    }
    public function update(Request $request, Teacher $teacher)
    {
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $validator = validator($request->all(), [
            "name" => "required|string|uppercase",
            "subject" => "required|string|uppercase",
        ]);
        if ($validator->fails()) {
            return $this->BadRequest($validator, "invalid input!");
        }
        $validated = $validator->validated();

        $teacher->update($validated);

        return $this->ok($teacher, "A Teacher has been Updated!");

    }
    public function delete(Request $request, Teacher $teacher)
    {
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $teacher->delete();
        return $this->ok(null, "Teacher has been deleted!");
    }
}

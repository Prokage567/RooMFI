<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function all(){
        return $this->ok(Teacher::all(), "all teachers");
    }
    public function store(Request $request){
        $validator = validator($request->all(), [
            "teacher_name" => "required|string",
        ]);
        if ($validator->fails()) {
            return $this->BadRequest($validator, "invalid input");
        }

        $validated = $validator->validated();
        $validated["user_id"] = $request->user()->id;

        $order = Teacher::create($validated);

        return $this->ok($order, "Order Created");
    }
    public function delete(Teacher $teacher){
        $teacher->delete();
        return $this->ok(null,"product has been deleted");
    }
}

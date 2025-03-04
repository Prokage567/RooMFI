<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SectionController extends Controller
{
   public function all()
   {
      return $this->ok(Section::all(), "all Sections!");
   }
   public function show(Section $section)
   {
      foreach($section->schedules as $schedule){
         $schedule->room;
         $schedule->teacher;
         $schedule->start_time = Carbon::parse($schedule->start_time)->format("h:i A");
         $schedule->end_time = Carbon::parse($schedule->end_time)->format("h:i A");
      }
      return $this->ok($section, "Section's name!");
   }
   public function store(Request $request)
   {
      if ($request->user()->role_id != "admin") {
         return $this->Forbidden("you are not an Admin!");
      }
      $validator = validator($request->all(), [
         "name" => "required|min:3|max:32|alpha_dash|string"
      ]);

      if ($validator->fails()) {
         return $this->BadRequest($validator);
      }
      $validated = $validator->validated();

      $section = Section::create($validated);

      return $this->ok($validated, "Section was succesfully created!");
   }
   public function update(Request $request, Section $section)
   {
      if ($request->user()->role_id != "admin") {
         return $this->Forbidden("you are not an Admin!");
      }
      $validator = validator($request->all(), [
         "name" => "required|min:3|max:32|alpha_dash|string"
      ]);

      if ($validator->fails()) {
         return $this->BadRequest($validator);
      }
      $validated = $validator->validated();

      $section->update($validated);

      return $this->ok($validated, "Section was succesfully updated!");
   }
   public function delete(Request $request, Section $section)
   {
      if ($request->user()->role_id != "admin") {
         return $this->Forbidden("you are not an Admin!");
      }
      $section->null();
      return $this->ok(null, " A section has been deleted!");
   }
}

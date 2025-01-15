<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
   public function all()
   {
      return $this->ok(Section::all(), "all Sections!");
   }
   public function show(Section $section)
   {
      return $this->ok($section, "Section's name!");
   }
   public function store(Request $request)
   {
      if ($request->user()->role_id != "admin") {
         return $this->Unauthorized("you are not an Admin!");
      }
      $validator = validator($request->all(), [
         "name" => "required|min:3|max:32|alpha_dash|string"
      ]);

      if ($validator->fails()) {
         return $this->BadRequest($validator);
      }
      $validated = $validator->validated();
      $section = Section::create($validated);
      return $this->ok($validated, "account was succesfully created!");
   }
   public function delete(Request $request, Section $section)
   {
      if ($request->user()->role_id != "admin") {
         return $this->Unauthorized("you are not an Admin!");
      }
      $section->null();
      return $this->ok(null, " A section has been deleted!");
   }
}

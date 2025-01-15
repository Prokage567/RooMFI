<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            "name" => "required|string"
        ]);

        if ($validator->fails()) {
            return $this->BadRequest($validator, "Subject's name is invalid");
        }
        $validated = $validator->validated();
        $subject = Subjects::create($validated);
        return $this->ok($validated,"Subject has been added!");
    }
}

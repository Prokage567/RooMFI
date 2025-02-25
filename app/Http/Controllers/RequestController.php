<?php

namespace App\Http\Controllers;

use App\Models\Requests;

use App\Models\User;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function all()
    { 
        $requests = Requests::with("user")->get();

        foreach ($requests as $request) {
                $request->user;
        }
       return $this->ok($requests,"all requests!");
    }
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            "user_id" => "required|exists:request,id",
            "room_id" => "required|exists:rooms,id",
            "reason" => "required|string"
        ]);
        if($validator->fails()){
            return $this->BadRequest($validator,"invalid inputs");
        }
        $validated = $validator->validated();
        Requests::create($validated);
        return $this->ok($validated,"made a request!");
    }
}

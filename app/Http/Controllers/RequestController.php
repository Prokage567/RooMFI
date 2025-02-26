<?php

namespace App\Http\Controllers;

use App\Models\Requests;

use App\Models\User;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function all()
    {
        $requests = Requests::all();
        foreach ($requests = Requests::with("user")->get() as $request) {
            $request->user;
        }
        return $this->ok($requests, "all requests!");
    }
    public function show(Requests $requests)
    {
        return $this->ok($requests, "A requests!");
    }
    public function store(Request $request)
    {
        if ($request->user()->role_id != "teacher") {
            return $this->Forbidden("you are not an Teacher!");
        }
        $validator = validator($request->all(), [
            "user_id" => "required|exists:users,id",
            "room_id" => "required|exists:rooms,id",
            "reason" => "required|string"
        ]);
        if ($validator->fails()) {
            return $this->BadRequest($validator, "invalid inputs");
        }
        $validated = $validator->validated();

        Requests::create($validated);
        return $this->ok($validated, "updated a request!");
    }
    public function update(Request $request, Requests $requests)
    {
        if ($request->user()->role_id != "teacher") {
            return $this->Forbidden("you are not an Admin!");
        }
        $validator = validator($request->all(), [
            "user_id" => "required|exists:users,id",
            "room_id" => "required|exists:rooms,id",
            "reason" => "required|string"
        ]);
        if ($validator->fails()) {
            return $this->BadRequest($validator, "invalid inputs");
        }
        $validated = $validator->validated();
        $requests->update($validated);
        return $this->ok($validated, "made a request!");
    }
    public function delete(Request $request, Requests $requests)
    {
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $requests->delete();
        return $this->ok(null, "A request has been deleted!");
    }
}

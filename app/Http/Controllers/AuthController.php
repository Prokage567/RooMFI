<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   
   
    public function checktoken(Request $request)
    {
        $user = $request->user();
        $user->profile();
        return response()->json([
            "ok" => false,
            "user" => $user,
            "message" => "token is valid"
        ]);
    }

    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            "name" => "required",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            return $this->BadRequest($validator, "all fields are required");
        }

        $validated = $validator->validated();

        if (!auth()->attempt([
                filter_var($validated["name"], FILTER_VALIDATE_EMAIL) ? "email" : "name" => $validated["name"],
                "password" => $validated["password"]
            ])){
            return $this->Unauthorized();
        }

        $token = auth()->user()->createToken("api")->accessToken;
        $user = auth()->user();
        $user->profile;

        return $this->authenticated([$user],$token ,"Logged in succesfully");
        
    }

    //register checker
    public function register(Request $request)
    {
        $validator = validator($request->all(), [
            "name" => "required|min:4|max:32|alpha_dash|string|unique:users",
            "email" => "required|email|max:255",
            "password" => "required|min:8|max:64|string|confirmed",
            "first_name" => "required|string|max:64|min:1",
            "last_name" => "required|string|max:64|min:1"
        ]);

        // $extension = $request->file('picture_extension')->getClientOriginalExtension();
        
        if ($validator->fails()) {
            return $this->BadRequest($validator);
        }
        //this creates the user login information in the users table
        $user = User::create($validator->safe()->only("name", "email", "password"));
        $profile_data = $validator->safe()->except("name", "email", "password", "picture_extension");
        // $profile_data["picture_extension"] = $extension;
        $user->profile()->create($profile_data);
        return $this->created($user, "account was succesfully created!");
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function section(Request $request){
         $validator = validator($request->all(), [
            "section" => "required|min:3|max:32|alpha_dash|string"
         ]);

         if ($validator -> fails()){
            return $this->BadRequest($validator);
         }
         user()->section($validator);
         return $this->ok($validator,"account was succesfully created!");
    }
}

<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /** this is created outputs if the data were right
    * @param mixed $data
    * @return mixed $data
    * @return mixed |\Illuminate\Http\JsonResponse
    */

    protected function created($data = [], $message = "created!"){
        return response()->json([
            "ok"=> true,
            "data" => $data,
            "message" => $message
        ], 200);
    }
    /**
     * this outputs the validator's message if the condition contains errors
     * @param mixed $validator
     * @param mixed $message
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    protected function BadRequest($validator, $message = "Bad Request!"){
        return response()->json([
            "ok"=> false,
            "errors" => $validator->errors(),
            "message" => $message
        ], 400);
    }
    /**
     * outputs unathorized request
     * @param mixed $message
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    protected function Unauthorized($message = "Invalid credentials!"){
        return response()->json([
            "ok" => false,
            "message" => $message
        ], 401);
    }

    /** this is when the user's credentials were accepted
    * @param mixed $data
    * @return mixed $data
    * @return mixed |\Illuminate\Http\JsonResponse
    */

    protected function authenticated($data = [], $token, $message = "ok!"){
        return response()->json([
            "ok" => true,
            "data" => $data,
            "token" => $token,
            "message"=> $message
        ], 200);
    }
    
    /** this is ok mfucntion in which outputs if a certain condition was met
    * @param mixed $data
    * @return mixed $data
    * @return mixed |\Illuminate\Http\JsonResponse
    */

    protected function ok($data = [], $message = "ok!"){
        return response()->json([
            "ok" => true,
            "data" => $data,
            "message"=> $message
        ], 200);
    }
    
}

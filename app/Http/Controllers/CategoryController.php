<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Schedule;

class CategoryController extends Controller
{
    /**
     * Index of all the Categories
     * Get:/api/category
     * @return JsonResponse|mixed
     */
    public function all(){
        $categories = Category::with("room")->get();
        foreach($categories as $category){
            foreach($category->room as $room){
                foreach($room->schedules as $sched){
                    $sched->start_time = Carbon::parse($sched->start_time)->format("h:i A");
                    $sched->end_time = Carbon::parse($sched->end_time)->format("h:i A");
                }
            }
        }
        return $this->ok($categories,"all Categories!");
    }

    /**
     * Shows a category by id 
     * Get:/api/category
     * @param \App\Models\Category $category
     * @return JsonResponse|mixed
     */
    public function show(Category $category){
        foreach($category->room as $room){
            $room->room;
            $room->schedules;
         }
        return $this->ok($category, "Category name!");
    }    
    
    /**
     * Creates new data to update
     * POST: /api/category 
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|mixed
     */
    public function store(Request $request){
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $validator = validator($request -> all(),[
            "category" => "required|String"
        ]);
        if($validator->fails()){
            return $this->BadRequest($validator,"Invalid input!");
        };

        $validated = $validator->validated();

        $category = Category::create($validated);

        return $this->ok($category,"Category Created!");    
    }

    /**
     * Updates the data by ID
     * patch: /api/category/{category}
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\category $category
     * @return JsonResponse|mixed
     */
    public function update(Request $request,Category $category){
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $validator = validator($request -> all(),[
           "category" => "required|String"
        ]);
        if($validator->fails()){
            return $this->BadRequest($validator,"Invalid input!");
        };

        $validated = $validator->validated();

        $category->update($validated);
        
        return $this->ok($validated,"category has been updated!");
    }

    /**
     * Deletes category by ID
     * delete:api/category/{category}
     * @param \App\Models\Category $category
     * @return JsonResponse|mixed
     */
    public function delete(Category $category, Request $request){
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $category->delete();
        return $this->ok(null,"category has been deleted!");
    }
}
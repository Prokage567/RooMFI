<?php

namespace App\Http\Controllers;

use App\Models\Room;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Index of all the rooms
     * Get:/api/room
     * @return JsonResponse|mixed
     */
    public function all()
    {
        $rooms = Room::all();
        foreach ($rooms as $room) {
            $room = Room::with("category")->get();
            foreach($room as $room_cat){
                $room_cat->category;
            }
        }
        return $this->ok($room, "all Rooms!");
    }
    public function search($keywords)
    {
        $keywords = array($keywords);
        $rooms = DB::table("rooms");
        // dd($keywords);
        foreach ($keywords as $key) {
            $rooms->orWhereLike("name", "%$key%");
        }
        return $this->ok($rooms->get(), "all Rooms!");
    }

    /**
     * Shows a room by id 
     * Get:/api/room
     * @param \App\Models\Room $room
     * @return JsonResponse|mixed
     */
    public function show(Room $rooms)
    {
        $rooms = Room::with("category")->get();
        foreach ($rooms as $room) {
            $room->category;
        }
        return $this->ok($rooms, "Room name!");
    }

    /**
     * Creates new data to update
     * POST: /api/room 
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|mixed
     */
    public function store(Request $request)
    {
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $validator = validator($request->all(), [
            "name" => "required|String",
            "category_id" => "required|exists:categories,id"
        ]);
        if ($validator->fails()) {
            return $this->BadRequest($validator, "Invalid input!");
        };
        $validated = $validator->validated();

        $room = Room::create($validated);

        return $this->ok($room, "Room Created!");
    }

    /**
     * Updates the data by ID
     * patch: /api/room/{room}
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @return JsonResponse|mixed
     */
    public function update(Request $request, Room $room)
    {
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $validator = validator($request->all(), [
            "name" => "required|String",
            "category_id" => "required|exists:categories,id"
        ]);
        if ($validator->fails()) {
            return $this->BadRequest($validator, "Invalid input!");
        }
        ;

        $validated = $validator->validated();

        $room->update($validated);

        return $this->ok($validated, "Room has been updated!");
    }

    /**
     * Deletes room by ID
     * delete:api/room/{room}
     * @param \App\Models\Room $room
     * @return JsonResponse|mixed
     */
    public function delete(Room $room, Request $request)
    {
        if ($request->user()->role_id != "admin") {
            return $this->Forbidden("you are not an Admin!");
        }
        $room->delete();
        return $this->ok(null, "Room has been deleted!");
    }
}
//done by Clare
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoomService;
use App\Models\Room;
use Illuminate\Support\Facades\Cache;

class RoomController extends Controller
{
    public function register(Request $request){
        try{
            if(Cache::get('adm') == 0){
                return response()->json(['error' => true, 'message' => "The user isn't a adm"], 403);
            }
            $id = RoomService::registerRoom($request);
            return response()->json(['error' => false, 'message' => "Room registered successfully, id:" . $id], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => true, 'message' => $th->getMessage()], 422);
        }
    }

    public function list(){
        try {
            $rooms = Room::all();
            return response()->json(['error' => false, 'rooms' => $rooms], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()], 422);
        }
    }

    public function checkRoom(Request $request){
        try {
            $params = [
                'room' => $request->input('room'),
                'event-start' => $request->input('event-start'),
                'event-end' => $request->input('event-end')
            ];
            $roomAvailability = RoomService::checkAvailableRoom($params);
            if(empty($roomAvailability)){
                return response()->json(['error' => false, 'message' => 'The room ' . $request->input('room') . ' is available to booking at this time'], 200);
            }
            return response()->json(['error' => true, 'message' => 'The room ' . $request->input('room') . " isn't available to booking at this time, check the booking list"], 422);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()], 422);
        }
    }
}

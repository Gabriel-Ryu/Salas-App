<?php

namespace App\Http\Controllers;

use App\Services\RoomService;
use App\Services\BookingService;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Services\UserService;
use Illuminate\Support\Facades\Cache;
use Exception;

class BookingController extends Controller
{
    public function create(Request $request){
        try {
            $roomId = RoomService::getIdRoom($request->input('room'));
            if(empty($roomId)){
                return response()->json(['error' => false, 'message' => "This room doesn't exist"], 422);
            }
            $room = BookingService::checkAvailableRoom([
                'room' => $roomId, 
                'event-start' => $request->input('event-start'), 
                'event-end' => $request->input('event-end')
            ]);
            if($room === false){
                throw new Exception("Error for check available rooms");
            }
            if(!empty($room)){
                return response()->json(['error' => false, 'message' => "The room is not available at this time"], 422);
            }
            $userBooking = BookingService::checkUser(Cache::get('user'));
            if($userBooking === false){
                throw new Exception("Error for check user bookings");
                
            }
            if(!empty($userBooking)){
                throw new Exception("The user {$request->input('user')} has already a active booking in " . $userBooking['room']);
            }

            $booking = BookingService::create([
                'user' => Cache::get('user'),
                'room' => $roomId,
                'event-start' => $request->input('event-start'),
                'event-end' => $request->input('event-end'),
                'status' => 1
            ]);
            return response()->json(['error' => false, 'id' => $booking], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()], 422);
        }
    }

    public function cancel(Request $request){
        try{
            $id = BookingService::cancel($request->input('idBooking'));
            if($id == null){
                return response()->json(['error' => false, 'message' => "The booking can't be cancelled, the start of meeting is less than 1 hour away."], 422);
            }
            return response()->json(['error' => false, 'message' => "Booking cancelled"], 200);
        }catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()], 422);
        }
    }

    public function update(Request $request){
        try {
            $update = BookingService::update([
                "id" => $request->input('idBooking'),
                "event-start" => $request->input('event-start'),
                "event-end" => $request->input('event-end')
            ]);
            if($update === false){
                throw new Exception("Error for check available rooms");
            }
            if(empty($update)){
                return response()->json(['error' => false, 'message' => "The room is not available at this time"], 422);
            }
            return response()->json(['error' => false, 'message' => "Booking updated to " . $request->input('event-start') . " at " . $request->input('event-end')], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()], 422);
        }
    }

    public function list(){
        try {
            $booking = Booking::all();
            return response()->json(['error' => false, 'bookings' => $booking], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()], 422);
        }
    }
}

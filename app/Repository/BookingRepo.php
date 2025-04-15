<?php
namespace App\Repository;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingRepo{
    public static function create($params){
        $booking = Booking::create($params);
        return ['id' => $booking->id, 'room' => $booking->room];
    }

    public static function checkBookingOfUser($user){
        return Booking::where('user', $user)
        ->where('status', 1)
        ->get()
        ->toArray();
    }

    public static function checkAvailableRoom($params) {
        $room = $params['room'];
        $start = $params['event-start'];
        $end = $params['event-end'];
        return Booking::where('room', $room)
        ->where(function($query) use ($start) {
            $query->whereRaw("'$start' BETWEEN DATE_SUB(`event-start`, INTERVAL 1 HOUR) AND `event-end`");
        })
        ->orWhere(function($query) use ($end) {
            $query->whereRaw("'$end' BETWEEN `event-start` AND `event-end`");
        })
        ->where('status', 1)
        ->get()
        ->toArray();
    }

    public static function cancel($id){
        $update = Booking::where('id', $id)
        ->update(['status'=> 0]);
        if($update === false){
            throw new \Exception("Error to update booking in database");
        }
        return $id;
    }

    public static function getBookingById($id){
        return Booking::where('id', $id)
        ->first()
        ->toArray();
    }

    public static function update($params){
        $update =  Booking::where('id', $params['id'])
        ->update(['event-start' => $params['event-start'], 'event-end' => $params['event-end']]);

        if($update === false){
            throw new \Exception("Error to update booking in database");
        }
        return true;
    }
}
<?php
namespace App\Repository;
use App\Models\Room;

class RoomRepo{
    public static function createRoom($params){
        return Room::insertGetId($params);
    }

    public static function getRoom($room){
        return Room::where('name', $room)
        ->get()
        ->toArray();
    }

    public static function getIdRoom($room){
        return Room::where('name', $room)
        ->pluck('id')
        ->first();
    }

    public static function checkAvailableRoom($room){
        return Room::where('name', $room)
        ->where('status', 1)
        ->get()
        ->toArray();
    }

    public static function reservingRoom($room){
        Room::where('id', $room)
        ->update(['status'=> 2]);
    }
}
<?php
namespace App\Services;

use App\Repository\UserRepo;
use App\Repository\RoomRepo;
use App\Repository\BookingRepo;

class RoomService{
    public static function registerRoom($params) {
        $status = $params->input('status');
        return RoomRepo::createRoom([
            'name' => $params->input('nameRoom'),
            'status' => isset($status) ? $status : 1
        ]);
    }

    public static function checkAvailableRoom($params){
        $roomId = RoomRepo::getIdRoom($params['room']);
        $params['room'] = $roomId;
        return BookingRepo::checkAvailableRoom($params);
    }

    public static function getIdRoom($room){
        return RoomRepo::getIdRoom($room);
    }
}
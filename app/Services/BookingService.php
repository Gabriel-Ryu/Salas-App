<?php
namespace App\Services;

use App\Repository\BookingRepo;
use App\Repository\RoomRepo;

class BookingService{
    public static function create($params) {
        $booking = BookingRepo::create($params);
        return $booking['id'];
    }

    public static function checkUser($user){
        return BookingRepo::checkBookingOfUser($user);
    }

    public static function checkAvailableRoom($params){
        $roomId = isset($params['id']) ? $params['id'] : RoomService::getIdRoom($params['room']);
        $params['room'] = $roomId;
        $roomAvailable = BookingRepo::checkAvailableRoom($params);
        return $roomAvailable;
    }

    public static function cancel($id){
        $booking = BookingRepo::getBookingById($id);
        $currentData = date("Y-m-d h:i:s");
        $canCancel = $booking['event-start'] > date("Y-m-d h:i:s", strtotime($currentData . ' +1 hour')) ? true : false;
        if($canCancel == false){
            return null;
        }
        return BookingRepo::cancel($id);
    }

    public static function update($params){
        $available = self::checkAvailableRoom($params);
        if(empty($available)){
            $update = BookingRepo::update($params);
            return $update;
        }
        return null;
    }
}
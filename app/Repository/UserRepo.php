<?php
namespace App\Repository;
use App\Models\User;

class UserRepo{
    public static function createUser($params){
        return User::insertGetId($params);
    }

    public static function getUser($user){
        return User::where('login', $user)
        ->get()
        ->toArray();
    }
}
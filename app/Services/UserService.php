<?php
namespace App\Services;
use App\Models\User;
use App\Repository\UserRepo;
use Illuminate\Support\Facades\Hash;

class UserService{
    public static function register($inputs) {
        if(!($inputs->input('adm') == 0 || $inputs->input('adm') == 1)){
            throw new \Exception("Adm field accept only 0 and 1 values", 1);
        }
        return UserRepo::createUser([
            'login' => $inputs['login'],
            'password' => Hash::make($inputs['password']),
            'adm' => $inputs['adm']
        ]);
        
    }

    public static function getUser($login) {
        return UserRepo::getUser($login);
    }
}
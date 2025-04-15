<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthenticatedRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthenticatedController extends Controller
{
    public function register (Request $request){
        try{
            $id = UserService::register($request);
            if($id === false){
                throw new Exception("Erro para cadastrar usuário");
            }
            return response()->json(['error' => false, 'id' => $id], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => true, 'message' => $th->getMessage()], 422);
        }
    }
    public function checkUser (Request $request){
        try{
           $user = UserService::getUser($request->input('login'));
           return response()->json(['error' => false, 'message' => "User " . $user[0]['login'] . " in base and ready to use"], 200);
        }catch(\Throwable $th){
            return response()->json(['error' => true, 'message' => $th->getMessage()], 422);
        }
    }
}

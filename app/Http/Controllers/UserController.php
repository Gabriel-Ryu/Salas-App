<?php
namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function list(){
        try {
            $users = User::all();
            return response()->json(['error' => false, 'user' => $users], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()], 422);
        }
    }
}

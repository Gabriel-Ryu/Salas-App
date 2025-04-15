<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Repository\UserRepo;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->get('/authentication', function(Request $request){
    return $request->user();
});

Route::post('/login',function(Request $request){
    Cache::forget('user');
    Cache::forget('adm');
    $credentials = $request->only(['login','password']);

    if(!$token = auth('api')->attempt($credentials)){
        abort(401, "Unauthorized");
    }
    $user = UserRepo::getUser($request->input('login'));
    Cache::put('user', $user[0]['id'], 3600);
    Cache::put('adm', $user[0]['adm'], 3600);

    return response()->json([
        'data' => [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]
    ]);
});

Route::group(['prefix' => 'auth'], function(){
    Route::post('register', [AuthenticatedController::class, 'register']);
    Route::post('checkUser', [AuthenticatedController::class, 'checkUser']);
});

Route::group(['prefix' => 'room', 'middleware' => 'auth:api'], function(){
    Route::post('register', [RoomController::class, 'register']);
    Route::get('list', [RoomController::class, 'list']);
    Route::post('checkRoom', [RoomController::class,'checkRoom']);
});

Route::group(['prefix' => 'booking', 'middleware' => 'auth:api'], function(){
    Route::post('create', [BookingController::class, 'create']);
    Route::post('cancel', [BookingController::class, 'cancel']);
    Route::post('update', [BookingController::class, 'update']);
    Route::get('list', [BookingController::class, 'list']);
});

Route::group(['prefix' => 'user'],function(){
    Route::get('list', [UserController::class, 'list']);
});
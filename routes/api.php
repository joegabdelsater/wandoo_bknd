<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OutingController;
use App\Http\Controllers\UserFriendController;


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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => ['cors']], function () {
    /** DONE Auth Routes */
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login.api');
    Route::post('/register', [ApiAuthController::class, 'register'])->name('register.api');

    /** DONE Categories route */
    Route::get('/categories', [CategoryController::class, 'index']);
});

Route::group(['middleware' => ['auth:api', 'cors']], function () {
    /** DONE Auth Routes */
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout.api');

    /** Done Categories */
    Route::get('/category/{category}/outings', [CategoryController::class, "show"]);

    /** outings */
    Route::get('/outings', [OutingController::class, 'index']); //Done
    Route::get('/outing/{outing}', [OutingController::class, 'show']); //Done
    Route::post('/outing', [OutingController::class, 'store']);

    /** user profile */
    Route::get('/profile', [UserController::class, 'index']);

    /** DONE friends */
    Route::get('/friends', [UserFriendController::class, 'index']);
    Route::post('/friends', [UserFriendController::class, 'store']);
    Route::delete('/friends/{userFriend}', [UserFriendController::class, 'destroy']);
});

<?php

namespace App\Http\Controllers;

use App\Models\UserFriend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $userId =  Auth::guard('api')->id();

        $_friends = UserFriend::where('user_id', $userId)
            ->orWhere('friend_id', $userId)
            ->with(['user', 'friend'])
            ->get();



        $friends = $_friends->map(function ($friend) use ($userId) {
            if ($friend->friend_id == $userId) {
                return $friend->user;
            } else {
                return $friend->friend;
            }
        });

        return response($friends, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId =  Auth::guard('api')->id();

        $valid = $request->validate([
            "friend_id" => "required|numeric|exists:users,id"
        ]);

        UserFriend::create([
            "user_id" => $userId,
            "friend_id" => $valid["friend_id"]
        ]);

        return response([
            "message" => "friendship created"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserFriend  $userFriend
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFriend $userFriend)
    {

        $userFriend->delete();
        return response(["message" => "friendship removed"], 200);
    }
}

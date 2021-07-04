<?php

namespace App\Classes;

use App\Models\UserFriend;

class Friendship
{

    public function getFriends($userId)
    {
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

        return $friends;
    }
}

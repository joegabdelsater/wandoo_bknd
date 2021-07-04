<?php

namespace App\Http\Controllers;

use App\Models\Outing;
use App\Models\OutingGuest;
use App\Classes\Friendship;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //status is public and fits my interests
        //status for friends and I am that persons friend
        //status public and fits my interest

        $categoriesIds =  Auth::guard('api')->user()->categories->pluck('id');
        $userId = Auth::guard('api')->id();

        //public outings which fit my category
        $publicOutings = Outing::whereHas('categories', function ($query) use ($categoriesIds) {
            $query->whereIn('categories.id', $categoriesIds)->where('join_status', 'public');
        })
            ->with('categories', 'user')->get();

        //outings to which I am invited
        $invitationOutings =  OutingGuest::where('user_id', $userId)->with('outing.user', 'outing.categories')->get()->pluck('outing');

        //outings which is for all friends
        $friendship = new Friendship();
        $friends = $friendship->getFriends($userId)->pluck('id');
        $friendsOutings = Outing::where('join_status', 'friends')->whereIn('user_id', $friends)->with('categories', 'user')->get();


        $outings = $publicOutings->concat($invitationOutings)->concat($friendsOutings);
        $sortedOutings = $outings->sortByDesc('date');

        return response($sortedOutings->values()->all(), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            "title" => "required|max:255|string",
            "description" => "nullable|string",
            "date" => "date|required",
            "join_status" => "string|required"
            //need to add categories
            //need to add guests
        ]);

        $valid['user_id'] = Auth::guard('api')->id();
        Outing::create($valid);

        return response(["message" => "Outing successfully created!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outing  $outing
     * @return \Illuminate\Http\Response
     */
    public function show(Outing $outing)
    {
        $outing = Outing::with(['categories', 'user'])->find($outing->id);
        return response($outing, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outing  $outing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Outing $outing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outing  $outing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outing $outing)
    {
        //
    }
}

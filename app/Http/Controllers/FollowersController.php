<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;

class FollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        $this->authorize('follow', $user);

        if ( ! Auth::user()->isFollowing($user->id)) {
            Auth::user()->followOrUnfollow($user->id);
        }

        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        $this->authorize('follow', $user);

        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->followOrUnfollow($user->id);
        }

        return redirect()->route('users.show', $user);
    }
}

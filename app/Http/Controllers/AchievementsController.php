<?php

namespace App\Http\Controllers;

use App\Events\UserSuscribed;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        return View('index');
        // return response()->json([
        //     'unlocked_achievements' => [],
        //     'next_available_achievements' => [],
        //     'current_badge' => '',
        //     'next_badge' => '',
        //     'remaing_to_unlock_next_badge' => 0
        // ]);
    }

    public function store(Request $request)
    {

        event(new UserSuscribed($request->input('email')));
    }
}

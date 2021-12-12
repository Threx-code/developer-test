<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $user = User::where("id", $request->user_id)->get()->first();

        Comment::create([
            'body' => $request->body,
            'user_id' => $user->id
        ]);

        $count = Comment::where('user_id', $request->user_id)->count();
        $title = $next = '';

        switch ($count) {
            case (($count > 0) && ($count)):
                $title = "First Comment Written";
                $next = "You are " .  (3 - $count) . " point away from your next achievement";
                break;

            case $count == 3:
                $title = "First Comment Written";
                $next = "You are " .  (5 - $count) . " point away from your next achievement";
                break;

            case $count == 5:
                $title = "5 Comment Written";
                $next = "You are " .  (10 - $count) . " point away from your next achievement";
                break;

            case $count == 10:
                $title = "10 Comment Written";
                $next = "You are " .  (20 - $count) . " point away from your next achievement";
                break;

            case $count >= 20:
                $title = "20 Comment Written";
                if ($count > 20) {
                    $next = "You are " .  ($count - 20) . " point away from your highest achievement";
                } else {
                    $next = "You are achieved the highest point";
                }
                break;
        }


        return [
            'achievement_name' => $title,
            'next_achievement' => $next,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format("M-d-Y H:i:s"),
            ]

        ];
    }
}

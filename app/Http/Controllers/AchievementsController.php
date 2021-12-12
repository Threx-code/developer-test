<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Events\UserSuscribed;
use App\Services\BadgeService;
use App\Services\LessonService;
use App\Services\CommentService;
use Illuminate\Contracts\View\View;

class AchievementsController extends Controller
{
    public function index(Request $request, /* User $user */)
    {
        $user = User::where('id', $request->user)->get()->first();
        $data = $user->load('comments', 'lessons');
        $commentCount = count($data->comments);
        $lessonCount = count($data->lessons);
        $lessonService = new LessonService;
        $lesson_ser = $lessonService->show_lesson_counter_view($lessonCount);
        $commentService = new CommentService;
        $comment_ser = $commentService->show_comment_counter_view($commentCount);
        $badge = BadgeService::badge_service($lessonCount, $commentCount);

        return response()->json([
            'unlocked_achievements' => [$lesson_ser['list'],  $comment_ser['list']],
            'next_available_achievements' => [$lesson_ser['next'],  $comment_ser['next']],
            'current_badge' => $badge['badge_name'],
            'next_badge' => $badge['next_badge'],
            'remaing_to_unlock_next_badge' => $badge['next_badge_comment'],
        ]);
    }
}

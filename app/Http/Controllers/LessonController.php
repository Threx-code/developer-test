<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    Lesson
};
use Illuminate\Http\Request;
use App\Events\LessonWatched;
use App\Http\Requests\{
    LessonRequest,
    LessonWatchRequest
};

use App\Services\LessonService;

class LessonController extends Controller
{
    public function store(LessonRequest $request)
    {
        if ($request->validated()) {
            $lesson = new LessonService;
            return $lesson->create_lesson($request->title);
        }
    }


    public function user_watch(LessonWatchRequest $request)
    {
        if ($request->validated()) {
            $user = User::where("id", $request->user_id)->get()->first();
            $lesson = Lesson::where("id", $request->lesson_id)->get()->first();
            return event(new LessonWatched($lesson, $user));
        }
    }
}

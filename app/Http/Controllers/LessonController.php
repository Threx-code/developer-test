<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    Lesson
};
use Illuminate\Http\Request;
use App\Events\LessonWatched;
use App\Http\Requests\LessonRequest;
use App\Http\Requests\LessonWatchRequest;

class LessonController extends Controller
{
    public function store(LessonRequest $request)
    {
        if ($request->validated()) {
            $lesson = Lesson::create([
                'title' => $request->title
            ]);

            return response()->json($lesson);
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

<?php

namespace App\Services;

use App\Models\User;
use App\Models\Lesson;
use App\Enums\BadgeEnum;
use App\Enums\LessonEnum;
use Illuminate\Validation\Rule;

class LessonService
{

    public function lesson_service($user, $lesson)
    {
        $newId = $user->lessons()->whereIn('lesson_id', $lesson)->get()->first();
        if (empty($newId->pivot->lesson_id)) {
            $user->lessons()->attach($lesson->id,  ['watched' => true]);
        }

        $lessonCount = count(json_decode($user->lessons, true));
        $commentCount = count($user->comments);

        return [
            'achievement_name' => $this->lesson_counter($lessonCount)['title'],
            'next_achievement' => $this->lesson_counter($lessonCount)['next'],
            'badge' => BadgeService::badge_service($lessonCount, $commentCount),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format("M-d-Y H:i:s"),
            ]

        ];
    }

    /**
     * lesson_counter
     *
     * @param  mixed $lessonCount
     * @return array
     */
    private function lesson_counter($lessonCount): array
    {
        switch (($lessonCount != '')) {

            case (($lessonCount >= LessonEnum::first_watch) && ($lessonCount < LessonEnum::fifth_watch)):
                $title = LessonEnum::watched_1;
                $next = LessonEnum::watched_5;
                $num = LessonEnum::fifth_watch - $lessonCount;
                break;

            case (($lessonCount >= LessonEnum::fifth_watch) && ($lessonCount < LessonEnum::tenth_watch)):
                $title = LessonEnum::watched_5;
                $next = LessonEnum::watched_10;
                $num = LessonEnum::tenth_watch - $lessonCount;
                break;

            case (($lessonCount >= LessonEnum::tenth_watch) && ($lessonCount < LessonEnum::twentyfifth)):
                $title = LessonEnum::watched_10;
                $next = LessonEnum::watched_25;
                $num = LessonEnum::twentyfifth - $lessonCount;
                break;

            case (($lessonCount >= LessonEnum::twentyfifth) && ($lessonCount < LessonEnum::fifty_watch)):
                $title = LessonEnum::watched_25;
                $next = LessonEnum::watched_50;
                $num = LessonEnum::fifty_watch - $lessonCount;
                break;

            case $lessonCount >= LessonEnum::fifty_watch:
                $title = LessonEnum::watched_50;
                $num  = "You have achieved the highest point";


                break;
        }

        if ($lessonCount >= LessonEnum::fifty_watch) {
            $comment = $num;
        } else {
            $comment = sprintf("You are %u  point away from your next achievement (%s)", $num, $next);
        }
        return [
            'title' => $title,
            'next' => $comment,
        ];
    }
}

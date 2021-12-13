<?php

namespace App\Services;

use App\Models\{
    User,
    Comment
};
use App\Enums\CommentEnum;
use App\Services\BadgeService;

class CommentService
{
    public function comment_service($user_id)
    {
        $user = User::where("id", $user_id)->get()->first();
        $commentCount = Comment::where('user_id', $user_id)->count();
        $lessonCount = count(json_decode($user->lessons, true));

        return [
            'achievement_name' => $this->comment_count($commentCount)['title'],
            'next_achievement' => $this->comment_count($commentCount)['next'],
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
     * comment_count
     *
     * @param  mixed $commentCount
     * @return array
     */
    private function comment_count($commentCount): array
    {
        $next = $num = '';

        switch ($commentCount) {
            case (($commentCount >= CommentEnum::num_1) && ($commentCount < CommentEnum::num_3)):
                $title = CommentEnum::first_comment;
                $next = CommentEnum::three_comment;
                $num = CommentEnum::num_3 - $commentCount;
                break;

            case (($commentCount >= CommentEnum::num_3) && ($commentCount < CommentEnum::num_5)):
                $title = CommentEnum::three_comment;
                $next = CommentEnum::five_comment;
                $num = CommentEnum::num_5 - $commentCount;
                break;

            case (($commentCount >= CommentEnum::num_5) && ($commentCount < CommentEnum::num_10)):
                $title = CommentEnum::five_comment;
                $next = CommentEnum::ten_comment;
                $num = CommentEnum::num_10 - $commentCount;
                break;

            case (($commentCount >= CommentEnum::num_10) && ($commentCount < CommentEnum::num_20)):
                $title = CommentEnum::ten_comment;
                $next = CommentEnum::twenty_comment;
                $num = CommentEnum::num_10 - $commentCount;
                break;

            case ($commentCount >= CommentEnum::num_20):
                $title = CommentEnum::twenty_comment;
                $num = "You have achieved the highest point";
                break;
        }

        if ($commentCount >= CommentEnum::num_20) {
            $comment = $num;
        } else {
            $comment = sprintf("You are %u  point away from your next achievement of (%s)", $num, $next);
        }


        return [
            'title' => $title,
            'next' => $next,
            'comment' => $comment,
        ];
    }

    /**
     * show_comment_counter_view
     *
     * @param  mixed $commentCount
     * @return array
     */
    public function show_comment_counter_view($commentCount): array
    {
        $arr = [];
        for ($i = 1; $i <=  $commentCount; $i++) {
            $arr[] = $this->comment_count($i)['title'];
        }

        return [
            'list' => implode(', ', array_unique($arr)),
            'next' => $this->comment_count($commentCount)['next'],
        ];
    }
}

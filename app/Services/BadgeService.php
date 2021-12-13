<?php

namespace App\Services;

use App\Enums\BadgeEnum;

class BadgeService
{
    /**
     * badge_service
     *
     * @param  mixed $badgeCount
     * @return array
     */
    public static function badge_service($lessonCount, $commentCount): array
    {
        return self::badge_maker($lessonCount, $commentCount);
    }

    /**
     * badge_maker
     *
     * @param  mixed $badgeCount
     * @return array
     */
    private static function badge_maker($lessonCount, $commentCount): array
    {
        $badgeCount = $lessonCount + $commentCount;
        switch ($badgeCount) {
            case (($badgeCount >= BadgeEnum::beginner_num) && ($badgeCount < BadgeEnum::intermediate_num)):
                $badge = BadgeEnum::beginner;
                $nextBadge = BadgeEnum::intermediate;
                $badgeValue = BadgeEnum::intermediate_num - $badgeCount;
                break;

            case (($badgeCount >= BadgeEnum::intermediate_num) && ($badgeCount < BadgeEnum::advanced_num)):
                $badge = BadgeEnum::intermediate;
                $nextBadge = BadgeEnum::advanced;
                $badgeValue  = BadgeEnum::advanced_num - $badgeCount;
                break;

            case (($badgeCount >= BadgeEnum::advanced_num) && ($badgeCount < BadgeEnum::master_num)):
                $badge = BadgeEnum::advanced;
                $nextBadge = BadgeEnum::master;
                $badgeValue = BadgeEnum::master_num - $badgeCount;
                break;

            case (($badgeCount >= BadgeEnum::master_num)):
                $badge = BadgeEnum::master;
                $badgeValue = "You have achieved the highest badge";
                break;
        }

        if ($badgeCount >= BadgeEnum::master_num) {
            $comment = $badgeValue;
        } else {
            $comment = sprintf("Your total point is %u. You are %u  point away from your next badge (%s)", $badgeCount, $badgeValue, $nextBadge);
        }

        return [
            'badge_name' => $badge,
            'next_badge' => $nextBadge ?? '',
            'next_badge_comment' => $comment,
            'comment_count' => $commentCount,
            'lesson_count' => $lessonCount,
        ];
    }
}

<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class LessonEnum extends Enum
{
    const first_watch = 1;
    const fifth_watch = 5;
    const tenth_watch = 10;
    const twentyfifth = 25;
    const fifty_watch = 50;

    const watched_1 = "First Lessons Watched";
    const watched_5 = "5 Lessons Watched";
    const watched_10 = "10 Lessons Watched";
    const watched_25 = "25 Lessons Watched";
    const watched_50 = "50 Lessons Watched";
}

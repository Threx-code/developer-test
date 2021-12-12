<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BadgeEnum extends Enum
{
    const beginner = 'Beginner';
    const intermediate = 'Intermediate';
    const advanced = 'Advanced';
    const master = 'Master';

    const beginner_num = 0;
    const intermediate_num = 4;
    const advanced_num = 8;
    const master_num = 10;
}

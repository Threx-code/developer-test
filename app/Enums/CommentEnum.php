<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CommentEnum extends Enum
{
    const first_comment = "First Comment Written";
    const three_comment = "3 Comment Written";
    const five_comment = "5 Comment Written";
    const ten_comment = "10 Comment Written";
    const twenty_comment = "20 Comment Written";

    const num_1 = 1;
    const num_3 = 3;
    const num_5 = 5;
    const num_10 = 10;
    const num_20 = 20;
}

<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class IntervalEnum extends Enum
{
    const Weekly = 'weekly';
    const Monthly = 'monthly';
    const Yearly = 'yearly';
    const Everyday = 'everyday';
    const Custom = 'custom';
}

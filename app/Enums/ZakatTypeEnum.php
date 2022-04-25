<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ZakatTypeEnum extends Enum
{
    const DONASI = 'Donasi';
    const FITRAH = 'Fitrah';
}

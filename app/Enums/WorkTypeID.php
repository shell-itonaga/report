<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class WorkTypeID extends Enum
{
    // 製造
    const Manufacture = 1;
    // 電気設計
    const EDesign     = 2;
    // 機械設計
    const MDesign     = 3;
    // 基板
    const Substrate   = 4;
}

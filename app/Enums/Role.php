<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Role extends Enum
{
    // アドミニストレータ
    const Administrator = 0;
    // 管理者
    const Manager       = 1;
    // 一般社員
    const Employee      = 2;
    // 外注
    const Outsourcer    = 10;
}

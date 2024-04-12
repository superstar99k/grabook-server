<?php

namespace App\Enums\User;

use App\Enums\Enum;

/**
 * @method static static Free()
 * @method static static Premium()
 */
final class Type extends Enum
{
    /**
     * 無料会員
     */
    public const Free = 'free';
    /**
     * 有料会員
     */
    public const Premium = 'premium';
}

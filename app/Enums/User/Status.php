<?php

namespace App\Enums\User;

use App\Enums\Enum;

/**
 * @method static static Pending()
 * @method static static Activated()
 * @method static static Deactivated()
 */
final class Status extends Enum
{
    /**
     * 保留
     */
    public const Pending = 'pending';
    /**
     * 有効
     */
    public const Activated = 'activated';
    /**
     * 無効
     */
    public const Deactivated = 'deactivated';
}

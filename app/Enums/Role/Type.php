<?php

namespace App\Enums\Role;

use App\Enums\Enum;

/**
 * @method static static Admin()
 * @method static static User()
 * @method static static Company()
 */
final class Type extends Enum
{
    /**
     * 管理者
     */
    public const Admin = 'admin';
    /**
     * ユーザー
     */
    public const User = 'user';
    /**
     * 印刷会社
     */
    public const Company = 'company';
}

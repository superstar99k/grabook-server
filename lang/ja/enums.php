<?php

return [
    \App\Enums\Role\Type::class => [
        \App\Enums\Role\Type::Admin => '管理者',
        \App\Enums\Role\Type::User => 'ユーザー',
        \App\Enums\Role\Type::Company => '印刷会社',
    ],
    \App\Enums\User\Type::class => [
        \App\Enums\User\Type::Free => '無料会員',
        \App\Enums\User\Type::Premium => '有料会員',
    ],
    \App\Enums\User\Status::class => [
        \App\Enums\User\Status::Pending => '保留',
        \App\Enums\User\Status::Activated => '有効',
        \App\Enums\User\Status::Deactivated => '無効',
    ],
];

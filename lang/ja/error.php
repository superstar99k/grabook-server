<?php

use Symfony\Component\HttpFoundation\Response;

return [
    'http_default' => [
        Response::HTTP_BAD_REQUEST => 'ご指定のページは表示できません。',
        Response::HTTP_NOT_FOUND => 'ページが見つかりませんでした。',
        Response::HTTP_FORBIDDEN => 'ご指定の操作はできません。',
        Response::HTTP_INTERNAL_SERVER_ERROR => 'エラーが発生しました。',
    ],
    'failed_password_login' => 'メールアドレスまたはパスワードが一致しませんでした。',
    'foreign_key_constraint_fails' => '既に他のデータに紐づいてるため処理を実行できませんでした。',
];

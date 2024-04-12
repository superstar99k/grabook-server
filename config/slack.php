<?php

return [
    'destinations' => [
        \App\Utils\SlackNotifier::CHANNEL_ALERT => [
            'url' => env('SLACK_WEBHOOK_URL_ALERT'),
            'channel' => env('SLACK_CHANNEL_ALERT'),
        ],
        \App\Utils\SlackNotifier::CHANNEL_EMERGENCY => [
            'url' => env('SLACK_WEBHOOK_URL_EMERGENCY'),
            'channel' => env('SLACK_CHANNEL_EMERGENCY'),
        ],
    ],
];

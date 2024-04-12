<?php

namespace App\Utils;

use App\Exceptions\SystemException;
use App\Notifications\SlackNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;

class SlackNotifier
{
    /**
     * 通知時の色などの設定
     */
    public const MESSAGE_TYPE_ERROR = 'error';
    public const MESSAGE_TYPE_SUCCESS = 'success';

    /**
     * 通知先種別
     *
     * @see src/server/config/slack.php
     */
    public const CHANNEL_ALERT = 'alert';
    public const CHANNEL_EMERGENCY = 'emergency';

    /**
     * メンション
     */
    public const MENTION_CHANNEL = '<!channel>';

    /**
     * #watcher_alertへの送信
     *
     * @param array $params
     *                      string title
     *                      string message
     *                      array fields
     *                      string mention
     *
     * @return void
     */
    public static function sendAlert(array $params)
    {
        $params = static::prependMention($params);

        static::send(array_merge($params, ['error' => true, 'channel' => static::CHANNEL_ALERT]));
    }

    /**
     * #watcher_emergencyへの送信
     *
     * @param array $params
     *                      string title
     *                      string message
     *                      array fields
     *                      string mention
     *
     * @return void
     */
    public static function sendEmergency(array $params)
    {
        $params = static::prependMention($params);

        static::send(array_merge($params, ['error' => true, 'channel' => static::CHANNEL_EMERGENCY]));
    }

    /**
     * @param string $message
     * @param string|null $mention
     *
     * @return array
     */
    private static function prependMention(array $params): array
    {
        $params['message'] = $params['message'] . ' ' . ($params['mention'] ?? static::MENTION_CHANNEL);

        return $params;
    }

    /**
     * @param array $params
     *
     * @return void
     */
    public static function send(array $params)
    {
        $title = $params['title'];
        $message = $params['message'];
        $fields = $params['fields'] ?? [];
        $error = $params['error'] ?? false;
        $destination = config('slack.destinations.'.$params['channel'] ?? SlackNotifier::CHANNEL_ALERT);

        if (empty($destination)) {
            throw new SystemException('channel is invalid');
        }

        $url = $destination['url'];
        $channel = $destination['channel'];

        Notification::send(
            (new AnonymousNotifiable())->route('slack', $url),
            new SlackNotification($channel, $message, [
                'title' => $title,
                'url' => $url,
                'fields' => $fields,
                'error' => $error,
                'success' => !$error,
            ])
        );
    }
}

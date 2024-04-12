<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerifyMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var params
     */
    private array $params;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->text('emails.user_verify')
            ->subject(__('emails.subject.user_verify'))
            ->with('userVerifyUrl', $this->params['user_verify_url'])
            ->with('passwordTimeoutHour', config('auth.password_timeout_hour'));
    }
}

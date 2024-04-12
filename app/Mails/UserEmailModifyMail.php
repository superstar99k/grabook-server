<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEmailModifyMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var array
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
            ->text('emails.user_email_modify')
            ->subject(__('emails.subject.user_email_modify'))
            ->with('userVerifyUrl', $this->params['user_verify_url'])
            ->with('passwordTimeoutHour', config('auth.password_timeout_hour'));
    }
}

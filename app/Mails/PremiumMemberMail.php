<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PremiumMemberMail extends Mailable
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
            ->text('emails.premium_member_confirm')
            ->subject(__('emails.subject.premium_member'));
    }
}

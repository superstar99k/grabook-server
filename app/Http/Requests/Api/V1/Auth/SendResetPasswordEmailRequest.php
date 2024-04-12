<?php

namespace App\Http\Requests\Api\V1\Auth;

// vendor
use App\Http\Requests\Request;

class SendResetPasswordEmailRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'max:64',
                'email',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => __('validation.attributes.users.email'),
        ];
    }
}

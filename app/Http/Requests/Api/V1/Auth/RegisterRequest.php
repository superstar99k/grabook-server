<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'verification_code' => [
                'required',
                'string',
            ],
            'token' => [
                'nullable',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'verification_code' => '確認用コード',
            'token' => 'Stripeトークン',
        ];
    }
}

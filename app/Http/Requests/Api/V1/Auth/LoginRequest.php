<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
            'password' => [
                'required',
                'max:16',
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
            'password' => __('validation.attributes.users.password'),
        ];
    }
}

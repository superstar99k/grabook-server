<?php

namespace App\Http\Requests\Api\V1\Auth;

// vendor
use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'password' => [
                'required',
                'max:16',
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
            ],
            'verification_code' => [
                'required',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'password' => __('validation.attributes.users.password'),
            'password_confirmation' => __('validation.attributes.users.password_confirmation'),
            'verification_code' => __('validation.attributes.users.verification_code'),
        ];
    }
}

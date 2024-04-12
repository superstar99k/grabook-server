<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Request;
use App\Validation\Rules\NumDash;
use Illuminate\Validation\Rule;

class TemporaryRegisterRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:64',
            ],
            'postal_code' => [
                'required',
                new NumDash(),
                'max:8',
            ],
            'address' => [
                'required',
                'string',
                'max:128',
            ],
            'tel' => [
                'nullable',
                new NumDash(),
                'max:16',
            ],
            'email' => [
                'required',
                'max:64',
                'email',
                'confirmed',
                Rule::unique('users', 'email'),
            ],
            'email_confirmation' => [
                'required',
                'max:64',
                'email',
            ],
            'password' => [
                'required',
                'max:16',
            ],
            'plan' => [
                'required',
                Rule::in(\App\Enums\User\Type::getValues()),
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('validation.attributes.users.name'),
            'postal_code' => __('validation.attributes.users.postal_code'),
            'address' => __('validation.attributes.users.address'),
            'tel' => __('validation.attributes.users.tel'),
            'email' => __('validation.attributes.users.email'),
            'password' => __('validation.attributes.users.password'),
        ];
    }
}

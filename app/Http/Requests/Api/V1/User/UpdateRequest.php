<?php

namespace App\Http\Requests\Api\V1\User;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * @property string|null $name
 * @property string|null $email
 */
class UpdateRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'filled',
                'max:64',
                'string',
            ],
            'email' => [
                'filled',
                'max:64',
                'email',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => __('validation.attributes.user.name'),
            'email' => __('validation.attributes.user.email'),
        ];
    }
}

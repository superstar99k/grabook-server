<?php

namespace App\Http\Requests\Api\V1\User;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * @property string $name
 * @property string $email
 *
 * @method array rules()
 * @method array attributes()
 */
class StoreRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:64',
                'string',
            ],
            'email' => [
                'required',
                'max:64',
                'email',
                Rule::unique('users', 'email'),
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

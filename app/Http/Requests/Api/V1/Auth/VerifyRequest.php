<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * @method array rules()
 * @method array attributes()
 */
class VerifyRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'verification_code' => [
                'required',
                Rule::exists('users', 'verification_code'),
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'verification_code' => __('validation.attributes.users.verification_code'),
        ];
    }
}

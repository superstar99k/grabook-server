<?php

namespace App\Http\Requests\Api\V1\User;

use App\Http\Requests\Request;

/**
 * @property bool|null $in_deactivate
 *
 * @method array rules()
 * @method array attributes()
 */
class IndexRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'in_deactivate' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'in_deactivate' => __('validation.attributes.user.in_deactivate'),
        ];
    }
}

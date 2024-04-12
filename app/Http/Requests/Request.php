<?php

namespace App\Http\Requests;

use App\Exceptions\HttpNotFoundException;
use App\Exceptions\ValidationException;
use App\Utils\Arr;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * Rules for route params.
     * The same syntax with rules() method.
     *
     * @return void
     */
    public function routeRules()
    {
        return [
        ];
    }

    /**
     * @return void
     */
    public function prepareForValidation()
    {
        $this->validateRouteParams();

        return parent::prepareForValidation();
    }

    /**
     * validate route params
     *
     * @return void
     */
    public function validateRouteParams()
    {
        $rules = $this->routeRules();
        $factory = $this->container->make(ValidationFactory::class);
        $values = Arr::map($rules, fn ($value, $key) => $this->route($key));

        $validator = $factory->make($values, $rules, [], []);

        if ($validator->fails()) {
            throw new HttpNotFoundException();
        }
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }
}

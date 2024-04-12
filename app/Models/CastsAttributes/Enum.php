<?php

namespace App\Models\CastsAttributes;

use App\Exceptions\InvalidArgumentException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Enum implements CastsAttributes
{
    private string $enum;

    public function __construct(string $enum)
    {
        $this->enum = $enum;
    }

    public function get($model, $key, $value, $attributes)
    {
        if (is_null($value)) {
            return $value;
        }

        return new $this->enum(
            $value
        );
    }

    public function set($model, $key, $value, $attributes)
    {
        if (is_null($value)) {
            return $value;
        }

        if ($this->enum::hasValue((string) $value)) {
            return $value;
        }

        throw new InvalidArgumentException("The {$key} should be one of {$this->enum}'s value but passed {$value}.");
    }
}

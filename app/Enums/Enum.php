<?php

namespace App\Enums;

use App\Utils\Arr;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as BaseEnum;
use Illuminate\Contracts\Database\Eloquent\Castable;

abstract class Enum extends BaseEnum implements LocalizedEnum, Castable
{
    /**
     * @return array
     */
    public static function getKV(array|string|null $keys = null)
    {
        $kv = [];

        foreach (((array) $keys ?: static::getKeys()) as $key) {
            $kv[$key] = static::getValue($key);
        }

        return $kv;
    }

    /**
     * @return string
     */
    public static function getKVJson(array|string|null $keys = null, bool $camerize = true)
    {
        $kv = static::getKV($keys);

        if ($camerize) {
            $kv = Arr::camerizeKeys($kv);
        }

        return json($kv);
    }

    /**
     * @param mixed $excludes = []
     *
     * @return array
     */
    public static function getOptions($excludes = [])
    {
        $options = Arr::map(static::getValues(), fn ($value) => [
            'value' => $value,
            'name' => static::getDescription($value),
        ]);

        if (!empty($excludes)) {
            $excludes = (array) $excludes;
            $options = array_filter($options, fn ($option) => !in_array($option['value'], $excludes));
        }

        return $options;
    }

    /**
     * @param mixed $excludes = []
     *
     * @return string
     */
    public static function getOptionJson($excludes = [])
    {
        return json(static::getOptions($excludes));
    }

    /**
     * Get the name of the caster class to use when casting from / to this cast target.
     *
     * @param array $arguments
     *
     * @return string
     * @return string|\Illuminate\Contracts\Database\Eloquent\CastsAttributes|\Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes
     */
    public static function castUsing(array $arguments)
    {
        return new \App\Models\CastsAttributes\Enum(static::class);
    }

    /**
     * @return array
     */
    public static function enumerate(): array
    {
        $data = [];

        foreach (static::getKeys() as $key) {
            $value = static::getValue($key);
            $label = static::getDescription($value);

            $data[] = [
                'key' => $key,
                'value' => $value,
                'label' => $label,
            ];
        }

        return $data;
    }

    /**
     * @return array
     */
    public static function enumerateAll(): array
    {
        $enums = config('enums.default');
        $enumerated = [];

        foreach ($enums as $class) {
            $enumerated[$class] = $class::enumerate();
        }

        return $enumerated;
    }
}

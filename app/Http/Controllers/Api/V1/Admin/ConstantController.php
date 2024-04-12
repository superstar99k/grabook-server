<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnonymousJsonResource;
use Illuminate\Support\Str;

class ConstantController extends Controller
{
    /**
     * クラス名（ネームスペース付き）からオブジェクトのキーを取得する
     *
     * @param string $class
     *
     * @return string
     */
    protected function resolveNamespase(string $class): string
    {
        return Str::snake(str_replace(['App\\Enums\\', '\\'], ['', '_'], $class));
    }

    /**
     * enumマスタの全値を取得する
     *
     * @return AnonymousJsonResource
     */
    public function index(): AnonymousJsonResource
    {
        $enums = config('enums.default');
        $enumerated = [];

        foreach ($enums as $class) {
            $namespace = $this->resolveNamespase($class);
            $enumerated[$namespace] = $class::enumerate();
        }

        return new AnonymousJsonResource($enumerated);
    }

    /**
     * validation.attributesマスタの全値を取得する
     *
     * @return AnonymousJsonResource
     */
    public function attributes(): AnonymousJsonResource
    {
        $attributes = __('validation.attributes');

        return new AnonymousJsonResource($attributes);
    }

    /**
     * @return AnonymousJsonResource
     */
    public function config(): AnonymousJsonResource
    {
        return new AnonymousJsonResource([
            'alert' => config('alert'),
        ]);
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as BaseJsonResource;

abstract class JsonResource extends BaseJsonResource
{
    /**
     * インターフェースの定義
     *
     * @return array
     */
    abstract public function define(): array;

    /**
     * @param mixed $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return $this->define();
    }
}

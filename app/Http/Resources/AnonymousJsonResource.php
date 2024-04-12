<?php

namespace App\Http\Resources;

class AnonymousJsonResource extends JsonResource
{
    /**
     * @return array
     */
    public function define(): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return is_array($this->resource)
            ? $this->resource
            : $this->resource->toArray();
    }
}

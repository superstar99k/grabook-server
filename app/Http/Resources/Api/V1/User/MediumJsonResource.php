<?php

namespace App\Http\Resources\Api\V1\User;

/**
 * @property \App\Models\User $resource
 */
class MediumJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function define(): array
    {
        return parent::define();
    }
}

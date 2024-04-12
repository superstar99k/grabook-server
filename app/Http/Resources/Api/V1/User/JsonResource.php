<?php

namespace App\Http\Resources\Api\V1\User;

use Illuminate\Http\Resources\Json\JsonResource as BaseJsonResource;

/**
 * @property \App\Models\User $resource
 */
class JsonResource extends BaseJsonResource
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
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'verification_generated_at' => (string) $this->resource->verification_generated_at,
            'email_verified_at' => (string) $this->resource->email_verified_at,
            'status' => (string) $this->resource->status,
            'update_user_id' => $this->resource->update_user_id,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}

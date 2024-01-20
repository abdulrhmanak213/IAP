<?php

namespace App\Http\Resources\User\Log;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user->name,
            'operation' => $this->operation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

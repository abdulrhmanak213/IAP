<?php

namespace App\Http\Resources\Admin\SystemLog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemLogResource extends JsonResource
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
            'user_id' => $this->user_id,
            'verb' => $this->verb,
            'request_body' => $this->request_body,
            'route' => $this->route,
            'response_code' => $this->response_code,
            'response_body' => $this->response_body,
            'created_at' => $this->created_at,
        ];
    }
}

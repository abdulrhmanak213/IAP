<?php

namespace App\Http\Resources\User\File;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileIndexResource extends JsonResource
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
            'owner_id' => $this->owner_id,
            'folder_id' => $this->folder_id,
            'folder_name' => $this->folder?->name,
            'is_owner' => $this->owner_id == auth()->user()->id,
            'is_shared' => $this->isShared($this->userFiles),
            'is_locked' => $this->status,
            'media' => MediaResource::make($this->getFirstMedia('file')),
            'created_at' => $this->created_at,
            'update_at' => $this->updated_at,
        ];
    }
}

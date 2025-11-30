<?php

namespace App\Http\Resources;

use App\Models\Format;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Format */
class FormatResource extends JsonResource
{
    #[\Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->format('d-m-Y H:i'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i'),
            'details' => $this->details,

            'user_id' => $this->user_id,

            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}

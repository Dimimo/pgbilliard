<?php

namespace App\Http\Resources;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Schedule */
class ScheduleResource extends JsonResource
{
    #[\Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'position' => $this->position,
            'player' => $this->player,
            'home' => $this->home,
            'created_at' => $this->created_at->format('d-m-Y H:i'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i'),

            'format' => new FormatResource($this->whenLoaded('format')),
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Position */
class PositionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rank' => $this->rank,
            'home' => $this->home,
            'created_at' => $this->created_at->format('d-m-Y H:i'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i'),

            'event_id' => $this->event_id,
            'player_id' => $this->player_id,

            'event' => new EventResource($this->whenLoaded('event')),
            'player' => new PlayerResource($this->whenLoaded('player')),
        ];
    }
}

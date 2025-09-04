<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Event */
class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'score1' => $this->score1,
            'score2' => $this->score2,
            'confirmed' => $this->confirmed,
            'games_count' => $this->whenCounted('games'),

            'date' => new DatesResource($this->whenLoaded('date')),
            'venue' => new VenueResource($this->whenLoaded('venue')),
            'team_1' => new TeamSimpleResource($this->whenLoaded('team_1')),
            'team_2' => new TeamSimpleResource($this->whenLoaded('team_2')),
        ];
    }
}

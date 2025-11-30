<?php

namespace App\Http\Resources;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Team */
class TeamResource extends JsonResource
{
    #[\Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'remark' => $this->whenNotNull($this->remark),
            'players_count' => $this->whenNotNull($this->activePlayers()->count()),

            'venue_id' => $this->venue_id,
            'season_id' => $this->season_id,

            'season' => $this->season->cycle,
            'venue' => new VenueResource($this->whenLoaded('venue')),

            'players' => $this->whenLoaded('players', PlayerResource::collection($this->activePlayers())),
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Player */
class PlayerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'captain' => $this->captain,
            'active' => $this->active,
            'games_lost' => $this->whenNotNull($this->games_lost),
            'games_played' => $this->whenNotNull($this->games_played),
            'games_won' => $this->whenNotNull($this->games_won),
            'participated' => $this->participated,
            'games_count' => $this->whenNotNull($this->games_count),
            'rank_count' => $this->whenNotNull($this->rank_count),
            'position_count' => $this->whenNotNull($this->position_count),

            'team' => new TeamResource($this->whenLoaded('team')),
            'season' => $this->team->season->cycle,
        ];
    }
}

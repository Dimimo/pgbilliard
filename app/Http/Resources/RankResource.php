<?php

namespace App\Http\Resources;

use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Rank */
class RankResource extends JsonResource
{
    #[\Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'max_games' => $this->max_games,
            'participated' => $this->participated,
            'won' => $this->won,
            'lost' => $this->lost,
            'played' => $this->played,
            'percentage' => $this->percentage,

            'season_id' => $this->season_id,
            'player_id' => $this->player_id,
            'user_id' => $this->user_id,

            'player' => new PlayerResource($this->whenLoaded('player')),
            'season' => new SeasonResource($this->whenLoaded('season')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}

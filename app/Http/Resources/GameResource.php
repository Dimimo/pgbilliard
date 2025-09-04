<?php

namespace App\Http\Resources;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Game */
class GameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'player_name' => $this->player->name,
            'player_id' => $this->player_id,
            'position' => $this->position,
            'home' => $this->home,
            'win' => $this->win,
        ];
    }
}

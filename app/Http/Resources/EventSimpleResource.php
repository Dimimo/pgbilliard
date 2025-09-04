<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Event */
class EventSimpleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'score1' => $this->score1,
            'score2' => $this->score2,
            'confirmed' => $this->confirmed,
            'team1' => new TeamSimpleResource($this->team_1),
            'team2' => new TeamSimpleResource($this->team_2),
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Event */
class EventGamesResource extends JsonResource
{
    #[\Override]
    public function toArray(Request $request): array
    {
        if ($this->games->count()) {
            $schedule = $this->games->first()->schedule->format->name;
        } else {
            $schedule = null;
        }
        return [
            'id' => $this->id,
            'score1' => $this->score1,
            'score2' => $this->score2,
            'confirmed' => $this->confirmed,
            'schedule' => $schedule,
            'date' => new DatesResource($this->whenLoaded('date')),
            'games' => $this->whenLoaded('games', new GameCollection($this->games)),
        ];
    }
}

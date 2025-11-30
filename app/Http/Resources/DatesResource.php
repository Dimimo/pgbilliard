<?php

namespace App\Http\Resources;

use App\Models\Date;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Date */
class DatesResource extends JsonResource
{
    #[\Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('d-m-Y'),
            'season' => new SeasonResource($this->whenLoaded('season')),
            'regular' => $this->regular,
            'title' => $this->title,
            'events' => new EventSimpleCollection(new EventSimpleResource($this->events)),
        ];
    }
}

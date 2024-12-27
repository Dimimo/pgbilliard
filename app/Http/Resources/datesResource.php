<?php

namespace App\Http\Resources;

use App\Models\Date;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Date */
class datesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'regular' => $this->regular,
            'title' => $this->title,
            'season' => $this->season,
            'remark' => $this->remark,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

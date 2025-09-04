<?php

namespace App\Http\Resources;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Venue */
class VenueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'contact_name' => $this->get_contact_name ?? $this->contact_name,
            'contact_nr' => $this->when($request->user, $this->get_contact_nr ?? $this->contact_nr),
            'created_at' => $this->created_at->format('d-m-Y H:i'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i'),
        ];
    }
}

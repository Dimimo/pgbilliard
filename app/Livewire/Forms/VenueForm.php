<?php

namespace App\Livewire\Forms;

use App\Models\Venue;
use Livewire\Attributes\Rule;
use Livewire\Form;

class VenueForm extends Form
{
    public Venue $venue;

    #[Rule('required|min:4|max:24')]
    public string $name;

    #[Rule('nullable|exists:App\Models\User,id')]
    public ?int $user_id;

    #[Rule('nullable|string|max:80')]
    public ?string $address;

    #[Rule('nullable|string|max:24')]
    public ?string $contact_name;

    #[Rule('nullable|string|max:24')]
    public ?string $contact_nr;

    #[Rule('nullable|string|max:255')]
    public ?string $remark;

    #[Rule('nullable|regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/')]
    public ?float $lat;

    #[Rule('nullable|regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/')]
    public ?float $lng;

    public function setVenue(Venue $venue)
    {
        $this->venue = $venue;
        $this->name = $venue->name;
        $this->user_id = $venue->user_id;
        $this->address = $venue->address;
        $this->contact_name = $venue->contact_name;
        $this->contact_nr = $venue->contact_nr;
        $this->remark = $venue->remark;
        $this->lat = $venue->lat;
        $this->lng = $venue->lng;
    }

    public function store()
    {
        $this->validate();
        Venue::create($this->only(['name', 'user_id', 'address', 'contact_nr', 'contact_name', 'remark', 'lat', 'lng']));
    }

    public function update()
    {
        $this->validate();
        $this->venue->update($this->all());
    }
}

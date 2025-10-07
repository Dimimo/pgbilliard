<?php

namespace App\Livewire\Forms;

use App\Http\Requests\VenueRequest;
use App\Models\Venue;
use Livewire\Attributes\Validate;
use Livewire\Form;

class VenueForm extends Form
{
    public Venue $venue;
    public bool $show_name;
    #[Validate]
    public string $name;
    #[Validate]
    public ?int $user_id = null;
    #[Validate]
    public ?string $address;
    #[Validate]
    public ?string $contact_name;
    #[Validate]
    public ?string $contact_nr;
    #[Validate]
    public ?string $remark;
    #[Validate]
    public ?string $lat;
    #[Validate]
    public ?string $lng;

    public function rules(): array
    {
        return  (new VenueRequest())->rules($this->venue, $this->user_id);
    }

    public function messages(): array
    {
        return (new VenueRequest())->messages();
    }

    public function setVenue(Venue $venue): void
    {
        $this->venue = $venue;
        $this->fill($venue);
        $this->show_name = ! $this->user_id;
    }

    public function create(): void
    {
        $validated = $this->validate();
        $this->venue = $this->venue->create($validated);
    }

    public function update(): void
    {
        $validated = $this->validate();
        $this->venue->update($validated);
        $this->venue->refresh();
    }
}

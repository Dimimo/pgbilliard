<?php

namespace App\Livewire\Forms;

use App\Models\User;
use App\Models\Venue;
use Livewire\Attributes\Rule;
use Livewire\Form;

class VenueForm extends Form
{
    public Venue $venue;

    public bool $show_name;

    #[Rule(['required', 'min:2', 'max:24', 'unique:'.Venue::class.',name'])]
    public string $name;

    #[Rule(['nullable', 'exists:'.User::class.',id'])]
    public ?int $user_id;

    #[Rule(['required', 'string', 'max:120'])]
    public ?string $address;

    #[Rule(['nullable', 'string'.'max:24'])]
    public ?string $contact_name;

    #[Rule(['nullable', 'string', 'max:24'])]
    public ?string $contact_nr;

    #[Rule(['nullable', 'string', 'max:255'])]
    public ?string $remark;

    #[Rule(['nullable', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'])]
    public ?float $lat;

    #[Rule(['nullable', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'])]
    public ?float $lng;

    public $messages = [
        'name.required' => 'The venue needs a name',
        'name.min' => 'The name of a venue needs to be at least 2 characters long',
        'name.max' => 'The name of a venue can not be longer than 24 characters',
        'name.unique' => 'This name already exists. Needs to be unique.',
        'address.required' => 'Please provide at least some description how to find the venue',
        'address.string' => 'An address has to alphanumerical',
        'address.max' => 'Please limit the address to 120 characters',
        'contact_name.max' => 'The contact name can not be longer than 24 characters',
        'contact_nr.max' => 'The contact number can not be longer than 24 characters',
        'lat.regex' => 'Please provide an existing latitude expressed in a decimal number',
        'lng.regex' => 'Please provide an existing latitude expressed in a decimal number',
    ];

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
        $this->show_name = true;
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
        $this->venue->refresh();
    }

    public function create()
    {
        $this->validate();
        $this->venue = $this->venue->create($this->all());
    }
}

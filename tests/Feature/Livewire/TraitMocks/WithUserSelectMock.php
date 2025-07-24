<?php

namespace Tests\Feature\Livewire\TraitMocks;

use App\Livewire\WithUsersSelect;

/**
use as: (see https://github.com/sebastianbergmann/phpunit/issues/5243)
public function test() {
    $mock = $this->createMock(WithUserSelectMock::class);
}
 */
class WithUserSelectMock
{
    use WithUsersSelect;
}

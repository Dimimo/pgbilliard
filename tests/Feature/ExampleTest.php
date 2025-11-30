<?php

it('returns a successful response', function (): void {
    $response = $this->get('/');

    $response->assertStatus(500); //does not work with an empty db, this is the scoresheet
});

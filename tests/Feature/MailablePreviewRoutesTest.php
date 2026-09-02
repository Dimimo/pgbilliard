<?php

it('does not expose mailable previews outside the local environment', function (string $path): void {
    expect(app()->environment())->not->toBe('local');

    $this->get($path)->assertNotFound();
})->with([
    '/mailable/date/1',
    '/mailable/date/1/admin',
    '/mailable/account-claimed/1',
    '/mailable/email-changed',
    '/mailable/captain-reminder/1',
    '/mailable/contact-players',
    '/mailable/game-reminder/1/1',
]);

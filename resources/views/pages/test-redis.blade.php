<?php

use function Livewire\Volt\state;
use Predis\Client;

state(['result' => function () {
    $client = new Predis\Client([
        'host' => 'redis-19999.c295.ap-southeast-1-1.ec2.redns.redis-cloud.com',
        'port' => 19999,
        'database' => 0,
        'username' => 'default',
        'password' => 'ur3kMiSuCpTY9sO4rWUSZCKARt90laP0',
    ]);

    $client->set('foo', 'bar');
    return $client->get('foo');
}])

?>

<x-layout>
    @volt
    <section>
        <p>result is : {{ $result }}</p>

    </section>
    @endvolt
</x-layout>



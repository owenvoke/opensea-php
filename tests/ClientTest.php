<?php

declare(strict_types=1);

use OwenVoke\OpenSea\Client;

it('gets instances from the client', function () {
    $client = new Client();
});

it('allows setting a custom url', function () {
    $client = new Client(null, null, 'https://opensea.test');
    expect($client->getEnterpriseUrl())->toBe('https://opensea.test');
});

it('allows setting a custom api version', function () {
    $client = new Client(null, 'v2');
    expect($client->getApiVersion())->toBe('v2');
});

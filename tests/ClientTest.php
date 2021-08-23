<?php

declare(strict_types=1);

use OwenVoke\OpenSea\Api\Asset;
use OwenVoke\OpenSea\Api\Bundle;
use OwenVoke\OpenSea\Api\Collection;
use OwenVoke\OpenSea\Api\Contract;
use OwenVoke\OpenSea\Client;

it('gets instances from the client', function () {
    $client = new Client();

    // Retrieves Asset instance
    expect($client->asset())->toBeInstanceOf(Asset::class);
    expect($client->assets())->toBeInstanceOf(Asset::class);

    // Retrieves Bundle instance
    expect($client->bundle())->toBeInstanceOf(Bundle::class);
    expect($client->bundles())->toBeInstanceOf(Bundle::class);

    // Retrieves Collection instance
    expect($client->collection())->toBeInstanceOf(Collection::class);
    expect($client->collections())->toBeInstanceOf(Collection::class);

    // Retrieves Contract instance
    expect($client->contract())->toBeInstanceOf(Contract::class);
    expect($client->contracts())->toBeInstanceOf(Contract::class);
});

it('allows setting a custom url', function () {
    $client = new Client(null, null, 'https://opensea.test');
    expect($client->getEnterpriseUrl())->toBe('https://opensea.test');
});

it('allows setting a custom api version', function () {
    $client = new Client(null, 'v2');
    expect($client->getApiVersion())->toBe('v2');
});

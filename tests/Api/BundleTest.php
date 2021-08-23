<?php

declare(strict_types=1);

use OwenVoke\OpenSea\Api\Bundle;

beforeEach(fn() => $this->apiClass = Bundle::class);

it('should show a list of bundles', function () {
    $expectedArray = ['bundles' => [['id' => 1]]];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/bundles')
        ->willReturn($expectedArray);

    expect($api->all())->toBe($expectedArray);
});

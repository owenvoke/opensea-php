<?php

declare(strict_types=1);

use OwenVoke\OpenSea\Api\Collection;

beforeEach(fn () => $this->apiClass = Collection::class);

it('should show a list of collections', function () {
    $expectedArray = ['collections' => [['id' => 1]]];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/collections')
        ->willReturn($expectedArray);

    expect($api->all())->toBe($expectedArray);
});

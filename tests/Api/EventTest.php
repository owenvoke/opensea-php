<?php

declare(strict_types=1);

use OwenVoke\OpenSea\Api\Event;

beforeEach(fn() => $this->apiClass = Event::class);

it('should show a contract by its address', function () {
    $expectedArray = ['asset_events' => ['id' => 1]];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with("/events")
        ->willReturn($expectedArray);

    expect($api->all())->toBe($expectedArray);
});

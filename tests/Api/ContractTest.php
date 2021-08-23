<?php

declare(strict_types=1);

use OwenVoke\OpenSea\Api\Contract;

beforeEach(fn () => $this->apiClass = Contract::class);

it('should show a contract by its address', function () {
    $contractAddress = '0x06012c8cf97bead5deae237070f9587f8e7a266d';
    $expectedArray = ['address' => $contractAddress];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with("/asset_contract/{$contractAddress}")
        ->willReturn($expectedArray);

    expect($api->show($contractAddress))->toBe($expectedArray);
});

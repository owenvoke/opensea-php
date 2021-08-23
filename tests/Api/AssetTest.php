<?php

declare(strict_types=1);

use OwenVoke\OpenSea\Api\Asset;

beforeEach(fn() => $this->apiClass = Asset::class);

it('should show a list of assets', function () {
    $expectedArray = ['assets' => [['id' => 1]]];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/assets')
        ->willReturn($expectedArray);

    expect($api->all())->toBe($expectedArray);
});

it('should show an asset by its address and token id', function () {
    $contractAddress = '0xb47e3cd837ddf8e4c57f05d70ab865de6e193bbb';
    $tokenId = '1';
    $expectedArray = ['id' => 1];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with("/asset/{$contractAddress}/{$tokenId}")
        ->willReturn($expectedArray);

    expect($api->show($contractAddress, $tokenId))->toBe($expectedArray);
});

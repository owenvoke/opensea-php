<?php

namespace OwenVoke\OpenSea\Tests;

use OwenVoke\OpenSea\Client;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Client\ClientInterface;
use ReflectionMethod;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var class-string */
    protected string $apiClass;

    protected function getApiMock(): MockObject
    {
        $httpClient = $this->getMockBuilder(ClientInterface::class)
            ->onlyMethods(['sendRequest'])
            ->getMock();

        $httpClient
            ->expects($this->any())
            ->method('sendRequest');

        $client = Client::createWithHttpClient($httpClient);

        return $this->getMockBuilder($this->apiClass)
            ->onlyMethods(['get', 'post', 'postRaw', 'patch', 'delete', 'put', 'head'])
            ->setConstructorArgs([$client])
            ->getMock();
    }

    protected function getMethod(object $object, string $methodName): ReflectionMethod
    {
        $method = new ReflectionMethod($object, $methodName);
        $method->setAccessible(true);

        return $method;
    }
}

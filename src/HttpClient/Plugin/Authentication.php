<?php

namespace OwenVoke\OpenSea\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\VersionBridgePlugin;
use Http\Promise\Promise;
use OwenVoke\OpenSea\Client;
use OwenVoke\OpenSea\Exception\RuntimeException;
use Psr\Http\Message\RequestInterface;

final class Authentication implements Plugin
{
    use VersionBridgePlugin;

    private string $tokenOrLogin;
    private ?string $password;
    private ?string $method;

    /**
     * @param string      $tokenOrLogin OpenSea private token/username/client ID
     * @param string|null $password     OpenSea password/secret (optionally can contain $method)
     * @param string|null $method       One of the AUTH_* class constants
     */
    public function __construct(string $tokenOrLogin, ?string $password, ?string $method)
    {
        $this->tokenOrLogin = $tokenOrLogin;
        $this->password = $password;
        $this->method = $method;
    }

    public function doHandleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $request = $request->withHeader(
            ...$this->getAuthorizationHeader()
        );

        return $next($request);
    }

    private function getAuthorizationHeader(): array
    {
        switch ($this->method) {
            case Client::AUTH_ACCESS_TOKEN:
                return ['X-API-KEY', $this->tokenOrLogin];
            default:
                throw new RuntimeException(sprintf('%s not yet implemented', $this->method));
        }
    }
}

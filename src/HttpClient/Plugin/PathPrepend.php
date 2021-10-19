<?php

namespace OwenVoke\OpenSea\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\VersionBridgePlugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

final class PathPrepend implements Plugin
{
    use VersionBridgePlugin;

    private string $path;

    /**
     * @param  string  $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function doHandleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $currentPath = $request->getUri()->getPath();
        if (strpos($currentPath, $this->path) !== 0) {
            $uri = $request->getUri()->withPath($this->path.$currentPath);
            $request = $request->withUri($uri);
        }

        return $next($request);
    }
}

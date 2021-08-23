<?php

namespace OwenVoke\OpenSea\HttpClient;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\HeaderAppendPlugin;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class Builder
{
    /** The object that sends HTTP messages. */
    private ClientInterface $httpClient;

    /** A HTTP client with all our plugins. */
    private HttpMethodsClientInterface $pluginClient;

    private RequestFactoryInterface $requestFactory;

    public StreamFactoryInterface $streamFactory;

    /** True if we should create a new Plugin client at next request. */
    private bool $httpClientModified = true;

    /** @var array<int, Plugin> */
    private array $plugins = [];

    private array $headers = [];

    public function __construct(
        ClientInterface $httpClient = null,
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface $streamFactory = null
    ) {
        $this->httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        if ($this->httpClientModified) {
            $this->httpClientModified = false;

            $plugins = $this->plugins;

            $this->pluginClient = new HttpMethodsClient(
                (new PluginClientFactory())->createClient($this->httpClient, $plugins),
                $this->requestFactory,
                $this->streamFactory
            );
        }

        return $this->pluginClient;
    }

    /**
     * Add a new plugin to the end of the plugin chain.
     *
     * @param Plugin $plugin
     *
     * @return void
     */
    public function addPlugin(Plugin $plugin)
    {
        $this->plugins[] = $plugin;
        $this->httpClientModified = true;
    }

    /**
     * Remove a plugin by its fully qualified class name (FQCN).
     *
     * @param string $fqcn
     *
     * @return void
     */
    public function removePlugin($fqcn)
    {
        foreach ($this->plugins as $idx => $plugin) {
            if ($plugin instanceof $fqcn) {
                unset($this->plugins[$idx]);
                $this->httpClientModified = true;
            }
        }
    }

    /**
     * Clears used headers.
     *
     * @return void
     */
    public function clearHeaders()
    {
        $this->headers = [];

        $this->removePlugin(HeaderAppendPlugin::class);
        $this->addPlugin(new HeaderAppendPlugin($this->headers));
    }

    /**
     * @param array $headers
     *
     * @return void
     */
    public function addHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);

        $this->removePlugin(HeaderAppendPlugin::class);
        $this->addPlugin(new HeaderAppendPlugin($this->headers));
    }

    /**
     * @param string $header
     * @param string $headerValue
     *
     * @return void
     */
    public function addHeaderValue($header, $headerValue)
    {
        if (! isset($this->headers[$header])) {
            $this->headers[$header] = $headerValue;
        } else {
            $this->headers[$header] = array_merge((array) $this->headers[$header], [$headerValue]);
        }

        $this->removePlugin(HeaderAppendPlugin::class);
        $this->addPlugin(new HeaderAppendPlugin($this->headers));
    }
}

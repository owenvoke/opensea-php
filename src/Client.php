<?php

declare(strict_types=1);

namespace OwenVoke\OpenSea;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use OwenVoke\OpenSea\Api\AbstractApi;
use OwenVoke\OpenSea\Api\Asset;
use OwenVoke\OpenSea\Api\Bundle;
use OwenVoke\OpenSea\Api\Collection;
use OwenVoke\OpenSea\Exception\BadMethodCallException;
use OwenVoke\OpenSea\Exception\InvalidArgumentException;
use OwenVoke\OpenSea\HttpClient\Builder;
use OwenVoke\OpenSea\HttpClient\Plugin\Authentication;
use OwenVoke\OpenSea\HttpClient\Plugin\PathPrepend;
use Psr\Http\Client\ClientInterface;

/**
 * @method Api\Asset asset()
 * @method Api\Asset assets()
 * @method Api\Bundle bundle()
 * @method Api\Bundle bundles()
 * @method Api\Collection collection()
 * @method Api\Collection collections()
 */
final class Client
{
    public const AUTH_ACCESS_TOKEN = 'access_token_header';

    public string $apiVersion;
    private ?string $enterpriseUrl = null;
    private Builder $httpClientBuilder;

    public function __construct(Builder $httpClientBuilder = null, ?string $apiVersion = null, ?string $enterpriseUrl = null)
    {
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();

        $builder->addPlugin(new RedirectPlugin());
        $builder->addPlugin(new AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri('https://api.opensea.io')));
        $builder->addPlugin(new HeaderDefaultsPlugin([
            'User-Agent' => 'opensea-php (https://github.com/owenvoke/opensea-php)',
        ]));

        $this->apiVersion = $apiVersion ?: 'v1';
        $builder->addHeaderValue('Accept', 'application/json');
        $builder->addPlugin(new PathPrepend(sprintf('/api/%s', $this->getApiVersion())));

        if ($enterpriseUrl) {
            $this->setEnterpriseUrl($enterpriseUrl);
        }
    }

    public static function createWithHttpClient(ClientInterface $httpClient): self
    {
        $builder = new Builder($httpClient);

        return new self($builder);
    }

    /** @throws InvalidArgumentException */
    public function api(string $name): AbstractApi
    {
        switch ($name) {
            case 'asset':
            case 'assets':
                return new Asset($this);

            case 'bundle':
            case 'bundles':
                return new Bundle($this);

            case 'collection':
            case 'collections':
                return new Collection($this);

            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }
    }

    public function authenticate(string $tokenOrLogin, ?string $password = null, ?string $authMethod = null): void
    {
        if (null === $password && null === $authMethod) {
            throw new InvalidArgumentException('You need to specify authentication method!');
        }

        if (null === $authMethod && $password === self::AUTH_ACCESS_TOKEN) {
            $authMethod = $password;
            $password = null;
        }

        $this->getHttpClientBuilder()->removePlugin(Authentication::class);
        $this->getHttpClientBuilder()->addPlugin(new Authentication($tokenOrLogin, $password, $authMethod));
    }

    private function setEnterpriseUrl(string $enterpriseUrl): void
    {
        $this->enterpriseUrl = $enterpriseUrl;

        $builder = $this->getHttpClientBuilder();
        $builder->removePlugin(AddHostPlugin::class);
        $builder->removePlugin(PathPrepend::class);

        $builder->addPlugin(new AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri($this->getEnterpriseUrl())));
        $builder->addPlugin(new PathPrepend(sprintf('/api/%s', $this->getApiVersion())));
    }

    public function getEnterpriseUrl(): ?string
    {
        return $this->enterpriseUrl;
    }

    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    public function __call(string $name, array $args): AbstractApi
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name), $e->getCode(), $e);
        }
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    protected function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
    }
}

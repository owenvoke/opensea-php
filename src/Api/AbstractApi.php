<?php

declare(strict_types=1);

namespace OwenVoke\OpenSea\Api;

use OwenVoke\OpenSea\Client;
use OwenVoke\OpenSea\HttpClient\Message\ResponseMediator;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractApi
{
    private Client $client;

    /** The per page parameter. */
    protected ?int $perPage = null;

    /** @param Client $client */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function getClient(): Client
    {
        return $this->client;
    }

    protected function getApiVersion(): string
    {
        return $this->client->getApiVersion();
    }

    public function configure()
    {
        return $this;
    }

    /**
     * Send a GET request with query parameters.
     *
     * @param  string  $path  Request path.
     * @param  array  $parameters  GET parameters.
     * @param  array  $requestHeaders  Request Headers.
     * @return array|string
     */
    protected function get(string $path, array $parameters = [], array $requestHeaders = [])
    {
        if (null !== $this->perPage && ! isset($parameters['limit'])) {
            $parameters['limit'] = $this->perPage;
        }

        if (array_key_exists('ref', $parameters) && null === $parameters['ref']) {
            unset($parameters['ref']);
        }

        if (count($parameters) > 0) {
            $path .= '?'.http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        }

        $response = $this->client->getHttpClient()->get($path, $requestHeaders);

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a HEAD request with query parameters.
     *
     * @param  string  $path  Request path.
     * @param  array  $parameters  HEAD parameters.
     * @param  array  $requestHeaders  Request headers.
     * @return ResponseInterface
     */
    protected function head(string $path, array $parameters = [], array $requestHeaders = []): ResponseInterface
    {
        if (array_key_exists('ref', $parameters) && null === $parameters['ref']) {
            unset($parameters['ref']);
        }

        return $this->client->getHttpClient()->head($path.'?'.http_build_query($parameters, '', '&', PHP_QUERY_RFC3986), $requestHeaders);
    }

    /**
     * Send a POST request with JSON-encoded parameters.
     *
     * @param  string  $path  Request path.
     * @param  array  $parameters  POST parameters to be JSON encoded.
     * @param  array  $requestHeaders  Request headers.
     * @return array|string
     */
    protected function post(string $path, array $parameters = [], array $requestHeaders = [])
    {
        return $this->postRaw(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders
        );
    }

    /**
     * Send a POST request with raw data.
     *
     * @param  string  $path  Request path.
     * @param  string  $body  Request body.
     * @param  array  $requestHeaders  Request headers.
     * @return array|string
     */
    protected function postRaw(string $path, string $body, array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->post(
            $path,
            $requestHeaders,
            $body
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a PATCH request with JSON-encoded parameters.
     *
     * @param  string  $path  Request path.
     * @param  array  $parameters  POST parameters to be JSON encoded.
     * @param  array  $requestHeaders  Request headers.
     * @return array|string
     */
    protected function patch(string $path, array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->patch(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a PUT request with JSON-encoded parameters.
     *
     * @param  string  $path  Request path.
     * @param  array  $parameters  POST parameters to be JSON encoded.
     * @param  array  $requestHeaders  Request headers.
     * @return array|string
     */
    protected function put(string $path, array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->put(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a DELETE request with JSON-encoded parameters.
     *
     * @param  string  $path  Request path.
     * @param  array  $parameters  POST parameters to be JSON encoded.
     * @param  array  $requestHeaders  Request headers.
     * @return array|string
     */
    protected function delete(string $path, array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->delete(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Create a JSON encoded version of an array of parameters.
     *
     * @param  array  $parameters  Request parameters
     * @return string|null
     */
    protected function createJsonBody(array $parameters): ?string
    {
        return (count($parameters) === 0) ? null : json_encode($parameters, empty($parameters) ? JSON_FORCE_OBJECT : 0);
    }
}

<?php

namespace OwenVoke\OpenSea\Api;

class Bundle extends AbstractApi
{
    public function all(array $parameters = []): array
    {
        return $this->get('/bundles', $parameters);
    }
}

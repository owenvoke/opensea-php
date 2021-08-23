<?php

namespace OwenVoke\OpenSea\Api;

class Collection extends AbstractApi
{
    public function all(array $parameters = []): array
    {
        return $this->get('/collections', $parameters);
    }
}

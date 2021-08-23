<?php

namespace OwenVoke\OpenSea\Api;

class Event extends AbstractApi
{
    public function all(array $parameters = []): array
    {
        return $this->get('/events', $parameters);
    }
}

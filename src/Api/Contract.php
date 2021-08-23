<?php

namespace OwenVoke\OpenSea\Api;

class Contract extends AbstractApi
{
    public function show(string $address): array
    {
        return $this->get(sprintf('/asset_contract/%s', rawurlencode($address)));
    }
}

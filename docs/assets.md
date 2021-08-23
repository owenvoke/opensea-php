# Assets API

[Back to the navigation](README.md)

Allows interacting with the [Assets API](https://docs.opensea.io/reference/getting-assets).

### Get a list of assets

```php
// Retrieve a standard list of assets with the default parameters
$response = $client->assets()->all();

// Retrieve a custom list of assets using parameters
$response = $client->assets()->all([
    'owner' => 'owners_address_here',
]);
```

### Get a specific asset

```php
$response = $client->assets()->show($address, $tokenId);
```

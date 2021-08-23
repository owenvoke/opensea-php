# Bundles API

[Back to the navigation](README.md)

Allows interacting with the [Bundles API](https://docs.opensea.io/reference/retrieving-bundles).

### Get a list of bundles

```php
// Retrieve a standard list of bundles with the default parameters
$response = $client->bundles()->all();

// Retrieve a custom list of bundles using parameters
$response = $client->bundles()->all([
    'owner' => 'owners_address_here',
]);
```

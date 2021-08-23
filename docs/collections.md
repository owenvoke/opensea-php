# Collections API

[Back to the navigation](README.md)

Allows interacting with the [Collections API](https://docs.opensea.io/reference/retrieving-collections).

### Get a list of 

```php
// Retrieve a standard list of collections with the default parameters
$response = $client->collections()->all();

// Retrieve a custom list of collections using parameters
$response = $client->collections()->all([
    'asset_owner' => 'owners_address_here',
]);
```

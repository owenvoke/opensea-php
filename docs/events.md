# Events API

[Back to the navigation](README.md)

Allows interacting with the [Events API](https://docs.opensea.io/reference/retrieving-asset-events).

### Get a list of events

```php
// Retrieve a standard list of events with the default parameters
$response = $client->events()->all();

// Retrieve a custom list of events using parameters
$response = $client->events()->all([
    'account_address' => 'accounts_wallet_address_here',
]);
```

# Contracts API

[Back to the navigation](README.md)

Allows interacting with the [Contracts API](https://docs.opensea.io/reference/retrieving-a-single-contract).

### Get a specific contract

```php
$response = $client->contracts()->show($contractAddress);
```

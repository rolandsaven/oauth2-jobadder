![](https://github.com/rolandsaven/oauth2-jobadder/workflows/Main%20Workflow/badge.svg)

# JobAdder Provider for OAuth 2.0 Client

This package provides JobAdder OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require rolandsaven/oauth2-jobadder
```

## Usage

Usage is the same as The League's OAuth client, using `\RolandSaven\OAuth2\Client\Provider\JobAdder` as the provider.

### Authorization Code Flow

```php
<?php
session_start();

$provider = new \RolandSaven\OAuth2\Client\Provider\JobAdder([
    'clientId'          => '{jobadder-client-id}',
    'clientSecret'      => '{jobadder-client-secret}',
    'scope'             => 'scope1,scope2,scope3',
    'redirectUri'       => 'https://example.com/callback-url',
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $account = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $account->getDisplayName());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}

```

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Contributions are welcome!


## Credits

- [Roland Kalocsaven](https://github.com/rolandsaven)
- [All Contributors](https://github.com/rolandsaven/oauth2-jobadder/contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/rolandsaven/oauth2-jobadder/blob/master/LICENSE) for more information.
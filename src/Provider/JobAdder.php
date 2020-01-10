<?php

/*
 * This file is part of oauth2-jobadder.
 *
 * (c) Roland Kalocsaven <rolandka@live.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace RolandSaven\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class JobAdder extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * @var null|array
     */
    protected $scope;

    /**
     * Returns the base URL for authorizing a client.
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://id.jobadder.com/connect/authorize';
    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://id.jobadder.com/connect/token';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://api.jobadder.com/v2/users/current';
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @return JobAdderResourceOwner
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new JobAdderResourceOwner($response);
    }

    /**
     * Check a provider response for errors.
     *
     * @param string $data Parsed response data
     *
     * @throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw new IdentityProviderException(
                $data['message'] ?: $response->getReasonPhrase(),
                $response->getStatusCode(),
                $response
            );
        }
    }

    /** Get the default scope used by this provider.
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return $this->scope;
    }

    /**
     * JobAdder uses a space to separate scopes.
     *
     * @return string
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }
}

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

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class JobAdderResourceOwner implements ResourceOwnerInterface
{
    /**
     * Raw response.
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new resource owner.
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * Returns the identifier of the authorized resource owner.
     *
     * @return null|int
     */
    public function getId()
    {
        return $this->response['userId'] ?: null;
    }

    /**
     * Returns resource owner first name.
     *
     * @return null|string
     */
    public function getFirstName()
    {
        return $this->response['firstName'] ?: null;
    }

    /**
     * Returns resource owner last name.
     *
     * @return null|string
     */
    public function getLastName()
    {
        return $this->response['lastName'] ?: null;
    }

    /**
     * Returns resource owner full name.
     *
     * @return string
     */
    public function getFullName()
    {
        return sprintf('%s %s', $this->getFirstName(), $this->getLastName());
    }

    /**
     * Returns the resource owner email address.
     *
     * @return null|string
     */
    public function getEmail()
    {
        return $this->response['email'] ?: null;
    }

    /**
     * Returns the resource owner avatar url.
     *
     * @return null|string
     */
    public function getAvatar()
    {
        return $this->response['links']['photo'] ?: null;
    }

    /**
     * Returns all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}

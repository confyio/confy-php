<?php

namespace Confy\Api;

use Confy\HttpClient\HttpClient;

/**
 * Organizations are owned by users and only (s)he can add/remove teams and projects for that organization. A default organization will be created for every user.
 */
class Orgs
{

    private $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * List all organizations the authenticated user is a member of.
     *
     * '/orgs' GET
     */
    public function list(array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('/orgs', $body, $options);

        return $response;
    }

    /**
     * Get the given organization if the authenticated user is a member.
     *
     * '/orgs/:org' GET
     *
     * @param $org Name of the organization
     */
    public function retrieve($org, array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('/orgs/'.rawurlencode($org).'', $body, $options);

        return $response;
    }

    /**
     * Update the given organization if the authenticated user is the owner. __Email__ is the only thing which can be updated.
     *
     * '/orgs/:org' PATCH
     *
     * @param $org Name of the organization
     * @param $email Billing email of the organization
     */
    public function update($org, $email, array $options = array())
    {
        $body = (isset($options['body']) ? $options['body'] : array());
        $body['email'] = $email;

        $response = $this->client->patch('/orgs/'.rawurlencode($org).'', $body, $options);

        return $response;
    }

}

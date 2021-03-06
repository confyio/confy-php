<?php

namespace Confy\HttpClient;

use Guzzle\Common\Event;

/**
 * AuthHandler takes care of devising the auth type and using it
 */
class AuthHandler
{
    private $auth;

    const HTTP_PASSWORD = 0;

    public function __construct(array $auth = array())
    {
        $this->auth = $auth;
    }

    /**
     * Calculating the Authentication Type
     */
    public function getAuthType()
    {

        if (isset($this->auth['username']) && isset($this->auth['password'])) {
            return self::HTTP_PASSWORD;
        }

        return -1;
    }

    public function onRequestBeforeSend(Event $event)
    {
        if (empty($this->auth)) {
            return;
        }

        $auth = $this->getAuthType();
        $flag = false;

        if ($auth == self::HTTP_PASSWORD) {
            $this->httpPassword($event);
            $flag = true;
        }

        if (!$flag) {
            throw new \ErrorException('Unable to calculate authorization method. Please check.');
        }
    }

    /**
     * Basic Authorization with username and password
     */
    public function httpPassword(Event $event)
    {
        $event['request']->setHeader('Authorization', sprintf('Basic %s', base64_encode($this->auth['username'] . ':' . $this->auth['password'])));
    }

}

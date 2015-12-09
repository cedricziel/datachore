<?php

namespace Datachore\Datastore;

use Datachore\Datastore;
use Google_Auth_AssertionCredentials;
use Google_Client;
use Google_Service_Datastore;

/**
 * Implements the Datastore using the offical PHP SDK. Requires remote credentials.
 */
class GoogleClientApi extends Datastore
{
    /**
     * oAuth scopes for the API client
     *
     * @var array
     */
    static $scopes = [
        "https://www.googleapis.com/auth/datastore",
        "https://www.googleapis.com/auth/userinfo.email",
    ];

    /**
     * To be overriden by subclasses to initialize the connection_status
     *
     * @param array $config
     */
    protected function __initialize(array $config)
    {
        // Not needed
    }

    /**
     * GoogleClientApi constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->__client = new Google_Client;
        if (isset($config['application-id'])) {
            $this->__client->setApplicationName($config['application-id']);
        } else {
            $this->__client->setApplicationName($_SERVER['APPLICATION_ID']);
        }

        if (isset($config['client-id'])) {
            $this->__client->setClientId($config['client-id']);
        }

        if (isset($confg['private-key']) && isset($config['service-account-name'])) {
            $this->__client->setAssertionCredentials(
                new Google_Auth_AssertionCredentials(
                    $config['service-account-name'],
                    self::$scopes,
                    $config['private-key']
                )
            );
        }

        $this->__service = new Google_Service_Datastore($this->__client);
    }

    public function Factory($type)
    {
        $className = 'Google_Service_Datastore_' . $type;

        return new $className;
    }

    public function isInstanceOf($object, $typeName)
    {
        return get_class($object) == 'Google_Service_Datastore_' . $typeName;
    }
}

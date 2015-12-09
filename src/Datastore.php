<?php

namespace Datachore;

use Datachore\Datastore\GoogleClientApi;
use Datachore\Datastore\GoogleRemoteApi;

abstract class Datastore
{
    /**
     * @var Datastore
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected $_datasetId;

    public function __construct(array $config = [])
    {
        $this->_datasetId = isset($config['datasetId']) ?
            $config['datasetId'] : $_SERVER['APPLICATION_ID'];

        $this->__initialize($config);
        self::$_instance = $this;
    }

    /**
     * To be overriden by subclasses to initialize the connection_status
     *
     * @param array $config
     */
    abstract protected function __initialize(array $config);

    /**
     * Returns the current instance
     *
     * @return Datastore|GoogleRemoteApi|GoogleClientApi
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new GoogleRemoteApi;
        }

        return self::$_instance;
    }

    public function getDatasetId()
    {
        return $this->_datasetId;
    }
}

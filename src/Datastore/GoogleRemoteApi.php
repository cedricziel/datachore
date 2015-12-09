<?php

namespace Datachore\Datastore;

use google\appengine\runtime\ApiProxy;

/** Implements the Data store by the Remote Stub API used by GAE SDK.
 */
class GoogleRemoteApi extends \Datachore\Datastore
{
    /**
     * @var string
     */
    protected $_host;

    public function call()
    {
        $args = func_get_args();

        return call_user_func_array([$this, 'call'], $args);
    }

    public function __call($func, $args)
    {
        $responseClass = str_replace('Request', 'Response', get_class($args[1]));
        $response = new $responseClass;

        return $this->_callMethod($func, $args[1], $response);
    }

    private function _callMethod($methodName, $request, $response)
    {
        ApiProxy::makeSyncCall(
            'datastore_v4',
            ucfirst($methodName),
            $request,
            $response
        );

        return $response;
    }

    public function Factory($type)
    {
        $className = 'google\\appengine\\datastore\\v4\\' . $type;

        return new $className;
    }

    public function isInstanceOf($object, $typeName)
    {
        return get_class($object) == 'google\\appengine\\datastore\\v4\\' . $typeName;
    }

    /**
     * @param array $config
     */
    protected function __initialize(array $config = [])
    {
        // Intentionally let blank. Remote API doesn't need configuration
    }
}

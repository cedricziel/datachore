<?php

namespace Datachore\Type;

use Datachore\Model;
use Datachore\TypeInterface;
use google\appengine\datastore\v4\Key as DataStoreKey;
use InvalidArgumentException;

class Key implements TypeInterface
{
    /**
     * @var DataStoreKey
     */
    protected $_key = null;

    /**
     * @var Model
     */
    protected $_entity = null;

    /**
     * @return Model
     */
    public function get()
    {
        if ($this->_entity) {
            return $this->_entity;
        } else {
            if ($this->_key) {
                $kindName = $this->_key->getPathElement(0)->getKind();
                $className = str_replace('_', '\\', $kindName);

                $entity = (new $className)
                    ->where('id', '==', $this->_key)
                    ->first();

                if ($entity) {
                    $this->_entity = $entity;

                    return $entity;
                }

            }
        }

        return false;
    }

    /**
     * @param $value
     */
    public function set($value)
    {
        switch (true) {
            case $value instanceof DataStoreKey:
                $this->_key = $value;

                return;

            case $value instanceof Model:
                $this->_entity = $value;
                $this->_key = $value->key;

                return;

            case $value === null:
                $this->_key = $this->_entity = null;

                return;

            default:
                throw new InvalidArgumentException(
                    "Unsupported Key Value Type"
                );
        }
    }

    /**
     * @return DataStoreKey
     */
    public function key()
    {
        if ($this->_key == null) {
            return null;
        }

        return clone $this->_key;
    }
}

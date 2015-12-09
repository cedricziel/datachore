<?php

namespace Datachore\Type;

use Datachore\TypeInterface;

class Double implements TypeInterface
{
    /**
     * @var float
     */
    protected $_val = null;

    /**
     * @return float
     */
    public function get()
    {
        return $this->_val;
    }

    /**
     * @param $value
     */
    public function set($value)
    {
        $this->_val = doubleval($value);
    }
}

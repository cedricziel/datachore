<?php

namespace Datachore\Type;

use Datachore\TypeInterface;

class Integer implements TypeInterface
{
    /**
     * @var int
     */
    protected $_val = null;

    /**
     * @return int
     */
    public function get()
    {
        return $this->_val;
    }

    /**
     * @param int $value
     */
    public function set($value)
    {
        $this->_val = intval($value);
    }
}

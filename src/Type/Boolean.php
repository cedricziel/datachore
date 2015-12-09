<?php

namespace Datachore\Type;

use Datachore\TypeInterface;

class Boolean implements TypeInterface
{
    protected $_val = null;

    public function get()
    {
        return $this->_val;
    }

    public function set($value)
    {
        $this->_val = $value ? true : false;
    }
}

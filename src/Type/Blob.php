<?php

namespace Datachore\Type;

use Datachore\TypeInterface;

class Blob implements TypeInterface
{
    protected $_val = null;

    public function get()
    {
        return $this->_val;
    }

    public function set($value)
    {
        $this->_val = $value;
    }
}

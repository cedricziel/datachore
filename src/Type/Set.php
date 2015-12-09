<?php

namespace Datachore\Type;

use Datachore\Collection;
use Datachore\Type;
use Datachore\TypeInterface;
use InvalidArgumentException;

class Set implements TypeInterface
{
    /**
     * @var Collection
     */
    protected $_val = null;

    /**
     * @var TypeInterface
     */
    protected $_type = null;

    /**
     * @param null $type
     *
     * @return Blob|BlobKey|Key|Set|TypeInterface|null
     */
    public function type($type = null)
    {
        if ($this->_type == null && $type) {
            if ($type instanceof TypeInterface) {
                $this->_type = $type;
            } else {
                $this->_type = Type::getTypeFromEnum($type);
            }
        }

        return $this->_type;
    }

    /**
     * @return Collection
     */
    public function get()
    {
        // Must allocate a new Datachore\Collection here since sets are modified
        // indirectly and externally.
        if ($this->_val === null) {
            $this->_val = new Collection;
        }

        return $this->_val;
    }

    public function set($value)
    {
        if ($value == null) {
            $this->_val = new Collection;
        } else {
            if ($value instanceof Collection) {
                $this->_val = clone $value;
            } else {
                if (is_array($value)) {
                    $this->_val = new Collection;
                    foreach ($value as $v) {
                        $this->_val[] = $v;
                    }
                } else {
                    throw new InvalidArgumentException("Invalid Set Value");
                }
            }
        }
    }
}

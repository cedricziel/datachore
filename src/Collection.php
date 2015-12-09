<?php

namespace Datachore;

use Illuminate\Support\Collection as IlluminateCollection;

class Collection extends IlluminateCollection
{
    /**
     * The items contained in the collection.
     *
     * @var Model[]
     */
    protected $items = [];

    public function save()
    {
        $this->__doOp('save');
    }

    private function __doOp($op)
    {
        if (count($this->items) > 0) {
            $transaction = $this->items[0]->startSave();

            foreach ($this->items as $item) {
                $item->$op($transaction);
            }

            $this->items[0]->endSave($transaction, $this);
        }
    }

    public function delete()
    {
        $this->__doOp('delete');
    }
}

<?php

namespace TNCPHP\DataStructures;

use Countable;
use Iterator;

abstract class DataStructure implements Arrayable, Countable, Iterator
{
    private $strategies;

    public function __construct()
    {
        $this->strategies = class_uses($this);
    }

    public function print($keyed = false)
    {
        print_r($this->toArray($keyed));
    }

    /**
     * @param string $strategyClass
     * @return bool
     */
    protected function isUsingStrategy(string $strategyClass)
    {
        $testResult = $this->strategies[$strategyClass] ?? false;

        return $testResult !== false;
    }
}
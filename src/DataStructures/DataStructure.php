<?php

namespace TNCPHP\DataStructures;

abstract class DataStructure
{
    private $strategies;

    public function __construct()
    {
        $this->strategies = class_uses($this);
    }

    /**
     * @param string $strategyClass
     * @return bool
     */
    protected function isUsingStrategy($strategyClass)
    {
        $testResult = $this->strategies[$strategyClass] ?? false;

        return $testResult !== false;
    }
}
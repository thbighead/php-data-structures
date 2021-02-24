<?php

namespace TNCPHP\DataStructures;

abstract class BaseDataStructure
{
    abstract public function isEmpty(): bool;

    abstract public function print(): void;
}
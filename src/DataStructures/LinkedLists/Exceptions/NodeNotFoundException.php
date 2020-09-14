<?php

namespace TNCPHP\DataStructures\LinkedLists\Exceptions;

use Exception;
use Throwable;

class NodeNotFoundException extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Unable to find any node with same reference passed', 0, $previous);
    }
}
<?php

namespace TNCPHP\DataStructures\LinkedLists\Exceptions;

use Exception;
use Throwable;

class EmptyLinkedListException extends Exception
{
    public function __construct(string $method, Throwable $previous = null)
    {
        parent::__construct("The method $method was called from an empty Linked List", 0, $previous);
    }
}
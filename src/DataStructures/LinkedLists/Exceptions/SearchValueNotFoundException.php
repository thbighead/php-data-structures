<?php

namespace TNCPHP\DataStructures\LinkedLists\Exceptions;

use Exception;
use Throwable;

class SearchValueNotFoundException extends Exception
{
    public function __construct($searchValue, Throwable $previous = null)
    {
        $message = is_callable($searchValue) ? 'Unable to find any node with data according your search function' :
            "Unable to find any node with data value of \"$searchValue\"";
        parent::__construct($message, 0, $previous);
    }
}
<?php

namespace TNCPHP\DataStructures;

use TNCPHP\MinorComponents\Node;

class LinkedList
{
    public $head;

    public function __construct()
    {
        $head = new Node;
    }
}
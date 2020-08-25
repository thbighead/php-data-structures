<?php

namespace TNCPHP\DataStructures\LinkedLists;

use TNCPHP\DataStructures\DataStructure;
use TNCPHP\DataStructures\LinkedLists\Strategies\WithTail;
use TNCPHP\MinorComponents\Node;

abstract class GenericLinkedList extends DataStructure
{
    /** @var Node|null $head */
    protected $head;

    public function __construct()
    {
        parent::__construct();

        $this->head = null;

        if ($this->isUsingStrategy(WithTail::class)) {
            /** @var GenericLinkedList|WithTail $this */
            $this->setTail(null);
        }
    }
}
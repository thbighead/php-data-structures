<?php

namespace TNCPHP\DataStructures\LinkedLists;

use TNCPHP\DataStructures\BaseDataStructure;
use TNCPHP\MinorComponents\Nodes\BaseNode;
use TNCPHP\MinorComponents\Nodes\Node;

abstract class BaseLinkedList extends BaseDataStructure
{
    protected $head;

    public abstract static function createNode($data): BaseNode;

    public function __construct(?Node $node = null)
    {
        $this->head = $node;
    }
}
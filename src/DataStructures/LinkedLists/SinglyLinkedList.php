<?php

namespace TNCPHP\DataStructures\LinkedLists;

use TNCPHP\MinorComponents\Node;

/**
 * Class SinglyLinkedList
 */
class SinglyLinkedList extends GenericLinkedList
{
    public function add(Node $node): GenericLinkedList
    {
        if ($this->head === null) {
            $this->head = $node;

            return $this;
        }

        $currentNode = $this->head;
        while ($nextNode = $currentNode->getNext()) {
            $currentNode = $nextNode;
        }
        $currentNode->setNext($node);

        return $this;
    }
}
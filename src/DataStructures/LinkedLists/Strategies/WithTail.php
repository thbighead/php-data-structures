<?php

namespace TNCPHP\DataStructures\LinkedLists\Strategies;

use TNCPHP\DataStructures\LinkedLists\GenericLinkedList;
use TNCPHP\MinorComponents\Node;

/**
 * Implements a tail pointer to always know the last element of list.
 */
trait WithTail
{
    /** @var Node $tail */
    private $tail;

    /**
     * @param Node $node
     *
     * @return GenericLinkedList|WithTail
     */
    public function add(Node $node): GenericLinkedList
    {
        /** @var GenericLinkedList|WithTail $this */
        if ($this->head === null) {
            $this->head = $node;
            $this->tail = $node;

            return $this;
        }

        $this->tail = $this->tail->setNext($node)->getNext();

        return $this;
    }

    /**
     * @return Node
     */
    public function getTail(): Node
    {
        return $this->tail;
    }

    /**
     * @param Node $tail
     *
     * @return GenericLinkedList|WithTail
     */
    public function setTail(Node $tail): GenericLinkedList
    {
        $this->tail = $tail;

        return $this;
    }
}
<?php

namespace TNCPHP\DataStructures\LinkedLists\Strategies;

use TNCPHP\DataStructures\LinkedLists\Exceptions\SearchValueNotFoundException;
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
     * @param mixed $dataSearch
     *
     * @return $this
     * @throws SearchValueNotFoundException
     */
    public function remove($dataSearch)
    {
        /** @var Node $currentNode */
        $currentNode = $this->head;
        $parentNode = $currentNode;

        while ($currentNode) {
            $currentData = $currentNode->getData();
            $nextNode = $currentNode->getNext();

            if ($this->compareData($currentData, $dataSearch)) { // Enter here if we found the node to remove
                $parentNode->setNext($nextNode);

                if (!$nextNode) {
                    $this->tail = $parentNode;
                }

                unset($currentNode);

                return $this;
            }

            $parentNode = $currentNode;
            $currentNode = $nextNode;
        }

        throw new SearchValueNotFoundException($dataSearch);
    }

    /**
     * @return Node
     */
    public function getTail(): Node
    {
        return $this->tail;
    }

    /**
     * @param Node|null $tail
     *
     * @return GenericLinkedList|WithTail
     */
    public function setTail($tail): GenericLinkedList
    {
        $this->tail = $tail;

        return $this;
    }
}
<?php

namespace TNCPHP\DataStructures\LinkedLists\Strategies;

use TNCPHP\DataStructures\LinkedLists\Exceptions\EmptyLinkedListException;
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

    public function add(Node $node): GenericLinkedList
    {
        /** @var GenericLinkedList|WithTail $this */
        try {
            $this->getLastNode()->setNext($node);
            $this->tail = $node;
        } catch (EmptyLinkedListException $exception) {
            $this->head = $this->tail = $node;
        }

        return $this;
    }

    /**
     * @return Node
     * @throws EmptyLinkedListException
     */
    public function getLastNode(): Node
    {
        $lastNode = $this->getTail();

        if (is_null($lastNode)) throw new EmptyLinkedListException(__METHOD__);

        return $lastNode;
    }

    /**
     * @return Node|null
     */
    public function getTail(): ?Node
    {
        return $this->tail;
    }

    /**
     * @param mixed $dataSearch
     *
     * @return $this
     * @throws SearchValueNotFoundException
     */
    public function removeByNodeData($dataSearch)
    {
        list($parentNode, $foundNode) = $this->searchByNodeDataWithParent($dataSearch);
        $data_comparing_result = $this->compareCurrentNodeData($dataSearch);
        $is_head = $foundNode === $this->head;
        $is_tail = $foundNode === $this->tail;

        if ($data_comparing_result && $is_head && $is_tail) {
            $this->head = $this->tail = null;
            unset($foundNode);
            return $this;
        }

        if ($data_comparing_result && $is_head) {
            $this->head = $this->head->getNext();
            unset($foundNode);
            return $this;
        }

        if ($data_comparing_result && $is_tail) {
            $parentNode->setNext($foundNode->getNext());
            $this->tail = $parentNode;
            unset($foundNode);
            return $this;
        }

        if ($data_comparing_result) {
            $parentNode->setNext($foundNode->getNext());
            unset($foundNode);
            return $this;
        }

        throw new SearchValueNotFoundException($dataSearch);
    }

    /**
     * @param Node|null $tail
     *
     * @return GenericLinkedList|WithTail
     */
    public function setTail(?Node $tail): GenericLinkedList
    {
        $this->tail = $tail;

        return $this;
    }
}
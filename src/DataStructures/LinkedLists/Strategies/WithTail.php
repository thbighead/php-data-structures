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
        $parentNode = null;

        foreach ($this as $key => $node) {
            /** @var Node|WithTail $node */
            $data_comparing_result = $this->compareData($node->getData(), $dataSearch);
            $is_head = !$parentNode;
            $is_tail = !$node->getNext();

            if ($data_comparing_result && $is_head && $is_tail) {
                $this->head = $this->tail = null;
                unset($node);
                return $this;
            }

            if ($data_comparing_result && $is_head) {
                $this->head = $this->head->getNext();
                unset($node);
                return $this;
            }

            if ($data_comparing_result && $is_tail) {
                $parentNode->setNext($node->getNext());
                $this->tail = $parentNode;
                unset($node);
                return $this;
            }

            if ($data_comparing_result) {
                $parentNode->setNext($node->getNext());
                unset($node);
                return $this;
            }

            $parentNode = $node;
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
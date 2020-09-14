<?php

namespace TNCPHP\DataStructures\LinkedLists\Strategies;

use TNCPHP\DataStructures\LinkedLists\Exceptions\SearchValueNotFoundException;
use TNCPHP\DataStructures\LinkedLists\GenericLinkedList;
use TNCPHP\MinorComponents\Node;

trait Circular
{
    /**
     * @param Node $node
     * @return GenericLinkedList|Circular $this
     */
    public function add(Node $node)
    {
        $node->setNext($this->head);

        return parent::add($node);
    }

    /**
     * @param mixed $dataSearch
     *
     * @return $this
     * @throws SearchValueNotFoundException
     */
    public function removeByNodeData($dataSearch)
    {
        $parentNode = null;
        $node_found_is_head = false;

        foreach ($this as $key => $node) {
            /** @var Node $node */
            $data_comparing_result = $this->compareCurrentNodeData($dataSearch);
            $is_last_node = $node->getNext() === $this->head;

            if (!$node_found_is_head && $data_comparing_result && !$parentNode) {
                $node_found_is_head = true;
                continue;
            }

            if (!$node_found_is_head && $data_comparing_result) {
                $parentNode->setNext($node->getNext());
                unset($node);
                return $this;
            }

            if ($node_found_is_head && $is_last_node) {
                $oldHead = $this->head;
                $this->head = $this->head->getNext();
                $node->setNext($this->head);
                unset($oldHead);
                return $this;
            }

            $parentNode = $node;
        }

        throw new SearchValueNotFoundException($dataSearch);
    }

    /*
     * (Re)Implementations
     */

    public function next()
    {
        $nextNode = $this->current()->getNext();
        $this->setCurrentNode($nextNode === $this->head ? null : $nextNode);
    }
}
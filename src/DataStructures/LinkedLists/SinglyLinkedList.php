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

    /**
     * @param mixed $dataSearch
     *
     * @return Node|null
     */
    public function search($dataSearch)
    {
        $currentNode = $this->head;

        while ($currentNode) {
            $currentData = $currentNode->getData();

            if (($search_is_callable = is_callable($dataSearch)) && $dataSearch($currentData) === true) {
                return $currentNode;
            }

            if (!$search_is_callable && $currentData === $dataSearch) {
                return $currentNode;
            }

            $currentNode = $currentNode->getNext();
        }

        return null;
    }
}
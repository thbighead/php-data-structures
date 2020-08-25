<?php

namespace TNCPHP\DataStructures\LinkedLists;

use TNCPHP\DataStructures\LinkedLists\Exceptions\SearchValueNotFoundException;
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
     * @throws SearchValueNotFoundException
     */
    public function search($dataSearch)
    {
        $currentNode = $this->head;

        while ($currentNode) {
            $currentData = $currentNode->getData();

            if ($this->compareData($currentData, $dataSearch)) {
                return $currentNode;
            }

            $currentNode = $currentNode->getNext();
        }

        throw new SearchValueNotFoundException($dataSearch);
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

                unset($currentNode);

                return $this;
            }

            $parentNode = $currentNode;
            $currentNode = $nextNode;
        }

        throw new SearchValueNotFoundException($dataSearch);
    }
}
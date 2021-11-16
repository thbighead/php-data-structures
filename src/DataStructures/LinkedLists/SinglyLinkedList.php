<?php

namespace TNCPHP\DataStructures\LinkedLists;

use TNCPHP\Exceptions\EmptyLinkedList;
use TNCPHP\Exceptions\NodeNotFoundInLinkedList;
use TNCPHP\MinorComponents\Nodes\BaseNode;
use TNCPHP\MinorComponents\Nodes\Node;

class SinglyLinkedList extends BaseLinkedList
{
    /**
     * @param $data
     * @return Node
     */
    public static function createNode($data): BaseNode
    {
        return new Node($data);
    }

    /**
     * @param mixed $value
     * @throws EmptyLinkedList
     * @throws NodeNotFoundInLinkedList
     */
    public function removeAfter($value)
    {
        /** @var Node $found */
        $found = $this->search($value);

        $obsoleteNode = $found->getNext();
        if ($obsoleteNode) {
            $found->setNext($obsoleteNode->getNext());
            unset($obsoleteNode);
        }
    }

    /**
     * @throws EmptyLinkedList
     */
    public function removeFromBeginning()
    {
        $obsoleteNode = $this->head;

        if ($this->isEmpty()) {
            throw new EmptyLinkedList();
        }

        $this->head = $this->head->getNext();
        unset($obsoleteNode);
    }

    /**
     * @throws EmptyLinkedList
     */
    public function removeFromEnd()
    {
        $parentNode = $obsoleteNode = $this->head;

        if ($this->isEmpty()) {
            throw new EmptyLinkedList();
        }

        while ($obsoleteNode->getNext() !== null) {
            $parentNode = $obsoleteNode;
            $obsoleteNode = $obsoleteNode->getNext();
        }

        if ($parentNode === $obsoleteNode) {
            $this->head = null;
            unset($obsoleteNode);
            return;
        }

        $parentNode->setNext($obsoleteNode->getNext());
        unset($obsoleteNode);
    }

    /**
     * @param mixed $value
     * @param Node $node
     * @throws EmptyLinkedList
     * @throws NodeNotFoundInLinkedList
     */
    public function insertAfter($value, Node $node)
    {
        /** @var Node $found */
        $found = $this->search($value);

        $node->setNext($found->getNext());
        $found->setNext($node);
    }

    public function insertAtBeginning(Node $node)
    {
        $node->setNext($this->head);
        $this->head = $node;
    }

    public function insertAtEnd(Node $node)
    {
        $lastNode = $this->head;

        if ($lastNode === null) {
            $this->head = $node;
            return;
        }

        while ($lastNode->getNext() !== null) {
            $lastNode = $lastNode->getNext();
        }

        $lastNode->setNext($node);
    }

    /**
     * @param mixed $value
     * @return Node|null
     * @throws EmptyLinkedList
     * @throws NodeNotFoundInLinkedList
     */
    public function search($value): ?Node
    {
        $currentNode = $this->head;

        if ($this->isEmpty()) {
            throw new EmptyLinkedList();
        }

        while ($currentNode !== null) {
            if (is_callable($value)) {
                if ($value($currentNode->getData())) {
                    return $currentNode;
                }
            } elseif ($currentNode->getData() === $value) {
                return $currentNode;
            }

            $currentNode = $currentNode->getNext();
        }

        throw new NodeNotFoundInLinkedList();
    }
}
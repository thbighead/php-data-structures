<?php

namespace TNCPHP\DataStructures\LinkedLists;

use TNCPHP\DataStructures\LinkedLists\Exceptions\SearchValueNotFoundException;
use TNCPHP\MinorComponents\Node;
use TNCPHP\MinorComponents\NodeWithPosition;

/**
 * Class SinglyLinkedList
 */
class SinglyLinkedList extends GenericLinkedList
{
    /** @var Node $currentNode */
    private $currentNode;

    public function add(Node $node): GenericLinkedList
    {
        if ($this->head === null) {
            $this->head = $node;

            return $this;
        }

        foreach ($this as $currentNode) {
            if (!$currentNode->getNext()) {
                $currentNode->setNext($node);
                break;
            }
        }

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
        foreach ($this as $key => $node) {
            if ($this->compareData($node->getData(), $dataSearch)) {
                return $node;
            }
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
        $parentNode = null;

        foreach ($this as $key => $node) {
            $data_comparing_result = $this->compareData($node->getData(), $dataSearch);

            if ($data_comparing_result && !$parentNode) {
                $this->head = $this->head->getNext();
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
     * @param mixed $dataSearch
     *
     * Just an alias to remove($dataSearch) function. Removes a node found by data value test. $dataSearch may be a
     * function which gets only one parameter that should be the actual node data, and should return true (if is the
     * data to remove) or false (if it shouldn't).
     *
     * @return $this
     * @throws SearchValueNotFoundException
     */
    public function removeByDataValue($dataSearch)
    {
        return $this->remove($dataSearch);
    }

    /*
     * Implementations
     */

    public function current()
    {
        return $this->currentNode;
    }

    public function next()
    {
        $this->currentNode = $this->current()->getNext();
    }

    public function key()
    {
        if ($this->current() instanceof NodeWithPosition) {
            return $this->current()->getPosition();
        }

        return $this->current()->getData();
    }

    public function valid()
    {
        return !!$this->current();
    }

    public function rewind()
    {
        $this->currentNode = $this->head;
    }

    public function count()
    {
        $counter = 0;

        foreach ($this as $node) {
            $counter++;
        }

        return $counter;
    }

    /**
     * Turns the list into a PHP array. Be careful when using $keyed == true, because there may be duplicated keys into
     * your linked list structure leading to data "disappearing".
     *
     * @param bool $keyed
     * @return array
     */
    public function toArray($keyed = false)
    {
        $array = [];

        foreach ($this as $key => $node) {
            if ($keyed) {
                $array[$key] = $node;
                continue;
            }

            $array[] = $node;
        }

        return $array;
    }
}
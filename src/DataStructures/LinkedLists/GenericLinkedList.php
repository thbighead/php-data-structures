<?php

namespace TNCPHP\DataStructures\LinkedLists;

use TNCPHP\DataStructures\DataStructure;
use TNCPHP\DataStructures\LinkedLists\Exceptions\EmptyLinkedListException;
use TNCPHP\DataStructures\LinkedLists\Exceptions\NodeNotFoundException;
use TNCPHP\DataStructures\LinkedLists\Strategies\WithTail;
use TNCPHP\MinorComponents\Node;
use TNCPHP\MinorComponents\NodeWithPosition;

abstract class GenericLinkedList extends DataStructure
{
    /** @var Node|null $head */
    protected $head;
    /** @var Node $currentNode */
    private $currentNode;

    public function __construct()
    {
        parent::__construct();

        $this->head = null;

        if ($this->isUsingStrategy(WithTail::class)) {
            /** @var GenericLinkedList|WithTail $this */
            $this->setTail(null);
        }
    }

    public function add(Node $node): GenericLinkedList
    {
        try {
            $this->getLastNode()->setNext($node);
        } catch (EmptyLinkedListException $exception) {
            $this->head = $node;
        }

        return $this;
    }

    /**
     * @return Node
     * @throws EmptyLinkedListException
     */
    public function getLastNode(): Node
    {
        $lastNode = null;

        foreach ($this as $node) {
            $lastNode = $node;
        }

        if (is_null($lastNode)) throw new EmptyLinkedListException(__METHOD__);

        return $lastNode;
    }

    /**
     * @param Node $nodeReference
     *
     * @return $this
     * @throws NodeNotFoundException
     */
    public function remove(Node $nodeReference)
    {
        list($parentNode, $foundNode) = $this->searchWithParent($nodeReference);
        $nodes_comparing_result = $foundNode === $nodeReference;

        if ($nodes_comparing_result && !$parentNode) {
            $this->head = $this->head->getNext();
            unset($foundNode);
            return $this;
        }

        if ($nodes_comparing_result) {
            $parentNode->setNext($foundNode->getNext());
            unset($foundNode);
            return $this;
        }

        throw new NodeNotFoundException();
    }

    /**
     * @param Node $nodeReference
     *
     * @return Node|null
     * @throws NodeNotFoundException
     */
    public function search(Node $nodeReference)
    {
        foreach ($this as $key => $node) {
            if ($node === $nodeReference) {
                return $node;
            }
        }

        throw new NodeNotFoundException();
    }

    /**
     * @param Node $nodeReference
     *
     * @return Node[]|null
     * @throws NodeNotFoundException
     */
    public function searchWithParent(Node $nodeReference)
    {
        $parentNode = null;

        foreach ($this as $key => $node) {
            if ($node === $nodeReference) {
                return [$parentNode, $node];
            }

            $parentNode = $node;
        }

        throw new NodeNotFoundException();
    }

    protected function compareCurrentNodeData($comparingNodeData)
    {
        $currentNodeData = $this->currentNode->getData();

        if (($search_is_callable = is_callable($comparingNodeData))) {
            return $comparingNodeData($currentNodeData) === true;
        }

        return $currentNodeData === $comparingNodeData;
    }

    /**
     * @param Node|null $node
     */
    protected function setCurrentNode(?Node $node)
    {
        $this->currentNode = $node;
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

        return print_r($this->current()->getData(), true);
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
     * your linked list structure leading to data "disappearing" (only the last keyed value shall remain).
     *
     * @param bool $keyed
     * @return array
     */
    public function toArray($keyed = false)
    {
        $array = [];

        foreach ($this as $key => $node) {
            if ($keyed) {
                $array[$key] = $node->getData();
                continue;
            }

            $array[] = $node->getData();
        }

        return $array;
    }
}
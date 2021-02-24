<?php

namespace TNCPHP\DataStructures\LinkedLists;

use TNCPHP\DataStructures\BaseDataStructure;
use TNCPHP\Exceptions\EmptyLinkedList;
use TNCPHP\MinorComponents\Nodes\BaseNode;
use TNCPHP\MinorComponents\Nodes\Node;

abstract class BaseLinkedList extends BaseDataStructure
{
    protected $head;

    public abstract static function createNode($data): BaseNode;

    public function __construct(?Node $node = null)
    {
        $this->head = $node;
    }

    public function isEmpty(): bool
    {
        return $this->head === null;
    }

    /**
     * @throws EmptyLinkedList
     */
    public function print(): void
    {
        $index = 0;
        $this->traverse(function (Node $currentNode) use (&$index) {
            if ($index === 0) {
                echo "{$currentNode->getData()}";
                $index++;
                return;
            }

            echo "->{$currentNode->getData()}";
        });

        echo "\n";
    }

    /**
     * @param callable $doSomethingWithNode
     * @throws EmptyLinkedList
     */
    public function traverse(callable $doSomethingWithNode)
    {
        $currentNode = $this->head;

        if ($this->isEmpty()) {
            throw new EmptyLinkedList();
        }

        while ($currentNode !== null) {
            $doSomethingWithNode($currentNode);
            $currentNode = $currentNode->getNext();
        }
    }
}
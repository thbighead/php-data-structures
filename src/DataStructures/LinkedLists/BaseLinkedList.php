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

    public function getHead(): ?BaseNode
    {
        return $this->head;
    }

    public function isEmpty(): bool
    {
        return $this->head === null;
    }

    /**
     * @param bool $output_to_string
     * @return string|null
     * @throws EmptyLinkedList
     */
    public function print(bool $output_to_string = false): ?string
    {
        $index = 0;
        $print_data = '';
        $this->traverse(function (BaseNode $currentNode) use (&$index, &$print_data) {
            if ($index === 0) {
                $print_data .= "{$currentNode->getData()}";
                $index++;
                return;
            }

            $print_data .= "->{$currentNode->getData()}";
        });

        if ($output_to_string) {
            return $print_data;
        }

        echo "$print_data\n";

        return null;
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
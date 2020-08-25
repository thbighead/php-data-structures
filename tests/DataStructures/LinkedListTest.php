<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TNCPHP\DataStructures\LinkedLists\SinglyLinkedList;
use TNCPHP\MinorComponents\Node;

final class LinkedListTest extends TestCase
{
    public function testAddNodeToSinglyLinkedList(): void
    {
        $singlyLinkedList = new SinglyLinkedList;
        $node = new Node('nothing');

        try {
            $return = $singlyLinkedList->add($node);
            $this->assertTrue((bool)$return);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }
}
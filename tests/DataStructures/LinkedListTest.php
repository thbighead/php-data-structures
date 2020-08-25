<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TNCPHP\DataStructures\LinkedLists\MinorComponents\NodeWithPosition;
use TNCPHP\DataStructures\LinkedLists\SinglyLinkedList;
use TNCPHP\DataStructures\LinkedLists\SinglyLinkedListWithTail;
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

    public function testAddNodeWithPositionToSinglyLinkedList(): void
    {
        $singlyLinkedList = new SinglyLinkedList;
        $node = new NodeWithPosition('nothing');

        $this->assertTrue(property_exists($node, 'position'));

        try {
            $return = $singlyLinkedList->add($node);
            $this->assertTrue((bool)$return);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testAddNodeToSinglyLinkedListWithTail(): void
    {
        $singlyLinkedLisWithTail = new SinglyLinkedListWithTail;
        $node = new Node('nothing');

        $this->assertTrue(property_exists($singlyLinkedLisWithTail, 'tail'));

        try {
            $return = $singlyLinkedLisWithTail->add($node);
            $this->assertTrue((bool)$return);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testAddNodeWithPositionToSinglyLinkedListWithTail(): void
    {
        $singlyLinkedLisWithTail = new SinglyLinkedListWithTail;
        $node = new NodeWithPosition('nothing');

        $this->assertTrue(property_exists($node, 'position'));
        $this->assertTrue(property_exists($singlyLinkedLisWithTail, 'tail'));

        try {
            $return = $singlyLinkedLisWithTail->add($node);
            $this->assertTrue((bool)$return);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testSearchNodeIntoSinglyLinkedList(): void
    {
        $singlyLinkedList = new SinglyLinkedList;

        $singlyLinkedList->add(new Node('nothing'))
            ->add(new Node('else'))
            ->add(new Node('matters'));

        $this->assertTrue($singlyLinkedList->search('never') === null);
        $this->assertTrue($singlyLinkedList->search('matters')->getData() === 'matters');
    }

    public function testSearchNodeWithPositionIntoSinglyLinkedList(): void
    {
        $singlyLinkedList = new SinglyLinkedList;

        $singlyLinkedList->add(new NodeWithPosition('nothing'))
            ->add(new NodeWithPosition('else'))
            ->add(new NodeWithPosition('matters'));

        $this->assertTrue($singlyLinkedList->search('never') === null);
        /** @var NodeWithPosition $foundNode */
        $this->assertTrue(
            ($foundNode = $singlyLinkedList->search('matters'))->getData() === 'matters'
        );
        $this->assertTrue($foundNode->getPosition() === 2);
    }
}
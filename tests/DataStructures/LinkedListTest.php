<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TNCPHP\DataStructures\LinkedLists\Exceptions\SearchValueNotFoundException;
use TNCPHP\DataStructures\LinkedLists\SinglyLinkedList;
use TNCPHP\DataStructures\LinkedLists\SinglyLinkedListWithTail;
use TNCPHP\MinorComponents\Node;
use TNCPHP\MinorComponents\NodeWithPosition;

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

        try {
            $singlyLinkedList->search('never');
            $this->fail('Found a node with value "never" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            $foundNode = $singlyLinkedList->search('matters');
            $this->assertTrue($foundNode->getData() === 'matters');
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testSearchNodeWithPositionIntoSinglyLinkedList(): void
    {
        $singlyLinkedList = new SinglyLinkedList;

        $singlyLinkedList->add(new NodeWithPosition('nothing'))
            ->add(new NodeWithPosition('else'))
            ->add(new NodeWithPosition('matters'));

        try {
            $singlyLinkedList->search('never');
            $this->fail('Found a node with value "never" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            /** @var NodeWithPosition $foundNode */
            $foundNode = $singlyLinkedList->search('matters');
            $this->assertTrue($foundNode->getData() === 'matters');
            $this->assertTrue($foundNode->getPosition() === 2);
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testRemoveNodeFromSinglyLinkedList(): void
    {
        $singlyLinkedList = new SinglyLinkedList;

        $singlyLinkedList->add(new Node('nothing'))
            ->add(new Node('else'))
            ->add(new Node('matters'));

        try {
            $singlyLinkedList->remove('never');
            $this->fail('Found a node to remove with value "never" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            $singlyLinkedList->remove('matters');
            try {
                $singlyLinkedList->search('matters');
                $this->fail('Found a node with value "matters" inside list after removing it!');
            } catch (SearchValueNotFoundException $exception) {
                $this->assertTrue(true);
            }
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testRemoveNodeWithPositionIntoSinglyLinkedList(): void
    {
        $singlyLinkedList = new SinglyLinkedList;

        $singlyLinkedList->add(new NodeWithPosition('nothing'))
            ->add(new NodeWithPosition('else'))
            ->add(new NodeWithPosition('matters'));

        try {
            $singlyLinkedList->remove('never');
            $this->fail('Found a node to remove with value "never" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            $foundNode = $singlyLinkedList->remove('matters');
            try {
                $singlyLinkedList->search('matters');
                $this->fail('Found a node with value "matters" inside list after removing it!');
            } catch (SearchValueNotFoundException $exception) {
                $this->assertTrue(true);
            }
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }
    }
}
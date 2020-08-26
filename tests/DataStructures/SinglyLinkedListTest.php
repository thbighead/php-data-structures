<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TNCPHP\DataStructures\LinkedLists\Exceptions\SearchValueNotFoundException;
use TNCPHP\DataStructures\LinkedLists\SinglyLinkedList;
use TNCPHP\MinorComponents\Node;
use TNCPHP\MinorComponents\NodeWithPosition;

final class SinglyLinkedListTest extends TestCase
{
    private const NOTHING = 'nothing';
    private const ELSE = 'else';
    private const MATTERS = 'matters';
    private const NEVER = 'never';

    private const POSITION = 'position';

    private static $singlyLinkedList;
    private static $singlyLinkedListUsingNodeWithPosition;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$singlyLinkedList = new SinglyLinkedList;
        self::$singlyLinkedListUsingNodeWithPosition = new SinglyLinkedList;
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::$singlyLinkedList = null;
        self::$singlyLinkedListUsingNodeWithPosition = null;
    }

    public function testAddNode(): void
    {
        try {
            $return = self::$singlyLinkedList->add(new Node(self::NOTHING));
            $this->assertTrue((bool)$return);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testAddNodeWithPosition(): void
    {
        $node = new NodeWithPosition(self::NOTHING);

        $this->assertTrue(property_exists($node, self::POSITION));

        try {
            $return = self::$singlyLinkedListUsingNodeWithPosition->add($node);
            $this->assertTrue((bool)$return);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testSearchNode(): void
    {
        self::$singlyLinkedList->add(new Node(self::ELSE))
            ->add(new Node(self::MATTERS));

        try {
            self::$singlyLinkedList->search(self::NEVER);
            $this->fail('Found a node with value "' . self::NEVER . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            $foundNode = self::$singlyLinkedList->search(self::MATTERS);
            $this->assertTrue($foundNode->getData() === self::MATTERS);
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testSearchNodeWithPosition(): void
    {
        self::$singlyLinkedListUsingNodeWithPosition->add(new NodeWithPosition(self::ELSE))
            ->add(new NodeWithPosition(self::MATTERS));

        try {
            self::$singlyLinkedListUsingNodeWithPosition->search(self::NEVER);
            $this->fail('Found a positioned node with value "' . self::NEVER . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            /** @var NodeWithPosition $foundNode */
            $foundNode = self::$singlyLinkedListUsingNodeWithPosition->search(self::MATTERS);
            $this->assertTrue($foundNode->getData() === self::MATTERS);
            $this->assertTrue($foundNode->getPosition() === 2);
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testRemoveNode(): void
    {
        try {
            self::$singlyLinkedList->remove(self::NEVER);
            $this->fail('Found a node to remove with value "' . self::NEVER . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            self::$singlyLinkedList->remove(self::MATTERS);
            try {
                self::$singlyLinkedList->search(self::MATTERS);
                $this->fail('Found a node with value "' . self::MATTERS . '" inside list after removing it!');
            } catch (SearchValueNotFoundException $exception) {
                $this->assertTrue(true);
            }
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testRemoveNodeWithPosition(): void
    {
        try {
            self::$singlyLinkedListUsingNodeWithPosition->remove(self::NEVER);
            $this->fail('Found a positioned node to remove with value "'
                . self::NEVER
                . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            self::$singlyLinkedListUsingNodeWithPosition->remove(self::MATTERS);
            try {
                self::$singlyLinkedListUsingNodeWithPosition->search(self::MATTERS);
                $this->fail('Found a positioned node with value "'
                    . self::MATTERS
                    . '" inside list after removing it!');
            } catch (SearchValueNotFoundException $exception) {
                $this->assertTrue(true);
            }
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }
    }
}
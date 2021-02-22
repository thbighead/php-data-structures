<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TNCPHP\DataStructures\LinkedLists\Exceptions\SearchValueNotFoundException;
use TNCPHP\DataStructures\LinkedLists\CircularlyLinkedList;
use TNCPHP\MinorComponents\Node;
use TNCPHP\MinorComponents\NodeWithPosition;

final class CircularlyLinkedListTest extends TestCase
{
    private const NOTHING = 'nothing';
    private const ELSE = 'else';
    private const MATTERS = 'matters';
    private const NEVER = 'never';

    private const POSITION = 'position';

    private static $circularlyLinkedList;
    private static $circularlyLinkedListUsingNodeWithPosition;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$circularlyLinkedList = new CircularlyLinkedList;
        self::$circularlyLinkedListUsingNodeWithPosition = new CircularlyLinkedList;
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::$circularlyLinkedList = null;
        self::$circularlyLinkedListUsingNodeWithPosition = null;
    }

    public function testAddNode(): void
    {
        try {
            $return = self::$circularlyLinkedList->add(new Node(self::NOTHING));
            $this->assertTrue((bool)$return);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }

        self::$circularlyLinkedList->print();
        self::$circularlyLinkedList->print(true);
    }

    public function testAddNodeWithPosition(): void
    {
        $node = new NodeWithPosition(self::NOTHING);

        $this->assertTrue(property_exists($node, self::POSITION));

        try {
            $return = self::$circularlyLinkedListUsingNodeWithPosition->add($node);
            $this->assertTrue((bool)$return);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }

        self::$circularlyLinkedListUsingNodeWithPosition->print();
        self::$circularlyLinkedListUsingNodeWithPosition->print(true);
    }

    public function testSearchNode(): void
    {
        self::$circularlyLinkedList->add(new Node(self::ELSE))
            ->add(new Node(self::MATTERS));

        try {
            self::$circularlyLinkedList->searchByNodeData(self::NEVER);
            $this->fail('Found a node with value "' . self::NEVER . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            $foundNode = self::$circularlyLinkedList->searchByNodeData(self::MATTERS);
            $this->assertTrue($foundNode->getData() === self::MATTERS);
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }

        self::$circularlyLinkedList->print();
        self::$circularlyLinkedList->print(true);
    }

    public function testSearchNodeWithPosition(): void
    {
        self::$circularlyLinkedListUsingNodeWithPosition->add(new NodeWithPosition(self::ELSE))
            ->add(new NodeWithPosition(self::MATTERS));

        try {
            self::$circularlyLinkedListUsingNodeWithPosition->searchByNodeData(self::NEVER);
            $this->fail('Found a positioned node with value "' . self::NEVER . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            /** @var NodeWithPosition $foundNode */
            $foundNode = self::$circularlyLinkedListUsingNodeWithPosition->searchByNodeData(self::MATTERS);
            $this->assertTrue($foundNode->getData() === self::MATTERS);
            $this->assertTrue($foundNode->getPosition() === 2);
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }

        self::$circularlyLinkedListUsingNodeWithPosition->print();
        self::$circularlyLinkedListUsingNodeWithPosition->print(true);
    }

    public function testRemoveNode(): void
    {
        try {
            self::$circularlyLinkedList->removeByNodeData(self::NEVER);
            $this->fail('Found a node to remove with value "' . self::NEVER . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            self::$circularlyLinkedList->removeByNodeData(self::MATTERS);
            try {
                self::$circularlyLinkedList->searchByNodeData(self::MATTERS);
                $this->fail('Found a node with value "' . self::MATTERS . '" inside list after removing it!');
            } catch (SearchValueNotFoundException $exception) {
                $this->assertTrue(true);
            }
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }

        self::$circularlyLinkedList->print();
        self::$circularlyLinkedList->print(true);
    }

    public function testRemoveNodeWithPosition(): void
    {
        try {
            self::$circularlyLinkedListUsingNodeWithPosition->removeByNodeData(self::NEVER);
            $this->fail('Found a positioned node to remove with value "'
                . self::NEVER
                . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            self::$circularlyLinkedListUsingNodeWithPosition->removeByNodeData(self::MATTERS);
            try {
                self::$circularlyLinkedListUsingNodeWithPosition->searchByNodeData(self::MATTERS);
                $this->fail('Found a positioned node with value "'
                    . self::MATTERS
                    . '" inside list after removing it!');
            } catch (SearchValueNotFoundException $exception) {
                $this->assertTrue(true);
            }
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }

        self::$circularlyLinkedListUsingNodeWithPosition->print();
        self::$circularlyLinkedListUsingNodeWithPosition->print(true);
    }
}
<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TNCPHP\DataStructures\LinkedLists\Exceptions\SearchValueNotFoundException;
use TNCPHP\DataStructures\LinkedLists\SinglyLinkedListWithTail;
use TNCPHP\MinorComponents\Node;
use TNCPHP\MinorComponents\NodeWithPosition;

final class SinglyLinkedListWithTailTest extends TestCase
{
    private const FACE = 'face';
    private const THE = 'the';
    private const STORM = 'storm';
    private const STRENGTH = 'strength';

    private const POSITION = 'position';
    private const TAIL = 'tail';

    private static $singlyLinkedListWithTail;
    private static $singlyLinkedListWithTailUsingNodeWithPosition;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$singlyLinkedListWithTail = new SinglyLinkedListWithTail;
        self::$singlyLinkedListWithTailUsingNodeWithPosition = new SinglyLinkedListWithTail;
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::$singlyLinkedListWithTail = null;
        self::$singlyLinkedListWithTailUsingNodeWithPosition = null;
    }

    public function testAddNode(): void
    {
        try {
            $return = self::$singlyLinkedListWithTail->add(new Node(self::FACE));
            $this->assertTrue(property_exists(self::$singlyLinkedListWithTail, self::TAIL));
            $this->assertTrue((bool)$return);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }

        self::$singlyLinkedListWithTail->print();
        self::$singlyLinkedListWithTail->print(true);
    }

    public function testAddNodeWithPosition(): void
    {
        $node = new NodeWithPosition(self::FACE);

        $this->assertTrue(property_exists(self::$singlyLinkedListWithTailUsingNodeWithPosition, self::TAIL));
        $this->assertTrue(property_exists($node, self::POSITION));

        try {
            $return = self::$singlyLinkedListWithTailUsingNodeWithPosition->add($node);
            $this->assertTrue((bool)$return);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }

        self::$singlyLinkedListWithTailUsingNodeWithPosition->print();
        self::$singlyLinkedListWithTailUsingNodeWithPosition->print(true);
    }

    public function testSearchNode(): void
    {
        self::$singlyLinkedListWithTail->add(new Node(self::THE))
            ->add(new Node(self::STORM));

        try {
            self::$singlyLinkedListWithTail->searchByNodeData(self::STRENGTH);
            $this->fail('Found a node with value "' . self::STRENGTH . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            $foundNode = self::$singlyLinkedListWithTail->searchByNodeData(self::STORM);
            $this->assertTrue($foundNode->getData() === self::STORM);
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }

        self::$singlyLinkedListWithTail->print();
        self::$singlyLinkedListWithTail->print(true);
    }

    public function testSearchNodeWithPosition(): void
    {
        self::$singlyLinkedListWithTailUsingNodeWithPosition->add(new NodeWithPosition(self::THE))
            ->add(new NodeWithPosition(self::STORM));

        try {
            self::$singlyLinkedListWithTailUsingNodeWithPosition->searchByNodeData(self::STRENGTH);
            $this->fail('Found a positioned node with value "' . self::STRENGTH . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            /** @var NodeWithPosition $foundNode */
            $foundNode = self::$singlyLinkedListWithTailUsingNodeWithPosition->searchByNodeData(self::STORM);
            $this->assertTrue($foundNode->getData() === self::STORM);
            $this->assertTrue($foundNode->getPosition() === 2);
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }

        self::$singlyLinkedListWithTailUsingNodeWithPosition->print();
        self::$singlyLinkedListWithTailUsingNodeWithPosition->print(true);
    }

    public function testRemoveNode(): void
    {
        try {
            self::$singlyLinkedListWithTail->removeByNodeData(self::STRENGTH);
            $this->fail('Found a node to remove with value "' . self::STRENGTH . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            self::$singlyLinkedListWithTail->removeByNodeData(self::STORM);
            try {
                self::$singlyLinkedListWithTail->searchByNodeData(self::STORM);
                $this->fail('Found a node with value "' . self::STORM . '" inside list after removing it!');
            } catch (SearchValueNotFoundException $exception) {
                $this->assertTrue(true);
            }
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }

        self::$singlyLinkedListWithTail->print();
        self::$singlyLinkedListWithTail->print(true);
    }

    public function testRemoveNodeWithPosition(): void
    {
        try {
            self::$singlyLinkedListWithTailUsingNodeWithPosition->removeByNodeData(self::STRENGTH);
            $this->fail('Found a positioned node to remove with value "'
                . self::STRENGTH
                . '" inside list without adding it!');
        } catch (SearchValueNotFoundException $exception) {
            $this->assertTrue(true);
        }

        try {
            self::$singlyLinkedListWithTailUsingNodeWithPosition->removeByNodeData(self::STORM);
            try {
                self::$singlyLinkedListWithTailUsingNodeWithPosition->searchByNodeData(self::STORM);
                $this->fail('Found a positioned node with value "'
                    . self::STORM
                    . '" inside list after removing it!');
            } catch (SearchValueNotFoundException $exception) {
                $this->assertTrue(true);
            }
        } catch (SearchValueNotFoundException $exception) {
            $this->fail($exception->getMessage());
        }

        self::$singlyLinkedListWithTailUsingNodeWithPosition->print();
        self::$singlyLinkedListWithTailUsingNodeWithPosition->print(true);
    }
}
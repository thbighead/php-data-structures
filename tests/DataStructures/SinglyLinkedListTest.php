<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TNCPHP\DataStructures\LinkedLists\BaseLinkedList;
use TNCPHP\DataStructures\LinkedLists\SinglyLinkedList;
use TNCPHP\Exceptions\EmptyLinkedList;
use TNCPHP\Exceptions\NodeNotFoundInLinkedList;
use TNCPHP\MinorComponents\Nodes\Node;

final class SinglyLinkedListTest extends TestCase
{
    private const NON_EXISTENT_NODE_VALUE = 'non_existent_value';
    /** @var SinglyLinkedList */
    protected static $singlyLinkedList;

    public function testConstructSinglyLinkedList()
    {
        self::$singlyLinkedList = new SinglyLinkedList;

        $this->assertInstanceOf(BaseLinkedList::class, self::$singlyLinkedList);
    }

    public function testSinglyLinkedListNodeCreation()
    {
        $randomNode = SinglyLinkedList::createNode($node_data_value = rand());
        $this->assertInstanceOf(Node::class, $randomNode);
        $this->assertEquals($randomNode->getData(), $node_data_value);
        $this->assertNull($randomNode->getNext());
    }

    /**
     * @throws EmptyLinkedList
     * @throws NodeNotFoundInLinkedList
     */
    public function testEmptySinglyLinkedList()
    {
        $this->expectException(EmptyLinkedList::class);
        $this->expectOutputString('');
        self::$singlyLinkedList->print();

        $this->assertTrue(self::$singlyLinkedList->isEmpty());

        // HADOOOOUUUUUUKEEEEEEN
        try {
            self::$singlyLinkedList->traverse(function () {
                return rand();
            });
        } catch (EmptyLinkedList $exception) {
            try {
                self::$singlyLinkedList->removeFromBeginning();
            } catch (EmptyLinkedList $exception) {
                try {
                    self::$singlyLinkedList->removeFromEnd();
                } catch (EmptyLinkedList $exception) {
                    // called by insertAfter() and removeAfter()
                    self::$singlyLinkedList->search(rand());
                }
            }
        }
    }

    /**
     * @throws EmptyLinkedList
     */
    public function testInsertAtBeginningWhenSinglyLinkedListIsEmpty()
    {
        $node_data_value = rand();

        $this->expectOutputString("$node_data_value\n");

        self::$singlyLinkedList->insertAtBeginning(SinglyLinkedList::createNode($node_data_value));
        $this->assertFalse(self::$singlyLinkedList->isEmpty());
        $this->assertInstanceOf(Node::class, self::$singlyLinkedList->getHead());
        $this->assertEquals($node_data_value, self::$singlyLinkedList->getHead()->getData());
        self::$singlyLinkedList->print();
    }

    /**
     * @throws EmptyLinkedList
     */
    public function testRemoveFromEndWhenSinglyLinkedListWithOnlyOneElement()
    {
        $this->expectException(EmptyLinkedList::class);

        self::$singlyLinkedList->removeFromEnd();
        $this->assertTrue(self::$singlyLinkedList->isEmpty());
        $this->assertNull(self::$singlyLinkedList->getHead());
        self::$singlyLinkedList->print();
    }

    /**
     * @throws EmptyLinkedList
     */
    public function testInsertAtEndWhenSinglyLinkedListIsEmpty()
    {
        $node_data_value = rand();

        $this->expectOutputString("$node_data_value\n");

        self::$singlyLinkedList->insertAtEnd(SinglyLinkedList::createNode($node_data_value));
        $this->assertFalse(self::$singlyLinkedList->isEmpty());
        $this->assertInstanceOf(Node::class, self::$singlyLinkedList->getHead());
        $this->assertEquals($node_data_value, self::$singlyLinkedList->getHead()->getData());
        self::$singlyLinkedList->print();
    }

    /**
     * @throws EmptyLinkedList
     */
    public function testRemoveFromBeginningWhenSinglyLinkedListWithOnlyOneElement()
    {
        $this->expectException(EmptyLinkedList::class);

        self::$singlyLinkedList->removeFromBeginning();
        $this->assertTrue(self::$singlyLinkedList->isEmpty());
        $this->assertNull(self::$singlyLinkedList->getHead());
        self::$singlyLinkedList->print();
    }

    /**
     * @throws EmptyLinkedList
     */
    public function testMakeSinglyLinkedListWithTwoNodes()
    {
        self::$singlyLinkedList->insertAtBeginning(SinglyLinkedList::createNode(rand()));
        $this->assertFalse(self::$singlyLinkedList->isEmpty());

        $counter = 0;
        self::$singlyLinkedList->traverse(function (Node $currentNode) use (&$counter) {
            $counter++;
        });
        $this->assertEquals(1, $counter);

        self::$singlyLinkedList->insertAtBeginning(SinglyLinkedList::createNode(rand()));
        $this->assertFalse(self::$singlyLinkedList->isEmpty());

        $counter = 0;
        self::$singlyLinkedList->traverse(function (Node $currentNode) use (&$counter) {
            $counter++;
        });
        $this->assertEquals(2, $counter);
    }

    /**
     * @throws EmptyLinkedList
     * @throws NodeNotFoundInLinkedList
     */
    public function testSinglyLinkedListNodeInsertions()
    {
        $this->expectException(NodeNotFoundInLinkedList::class);

        $to_be_inserted_at_beginning = rand();
        $to_be_inserted_at_end = rand();
        $to_be_inserted_after = rand();

        self::$singlyLinkedList->insertAtBeginning(SinglyLinkedList::createNode($to_be_inserted_at_beginning));
        $this->assertEquals($to_be_inserted_at_beginning, self::$singlyLinkedList->getHead()->getData());

        self::$singlyLinkedList->insertAtEnd(SinglyLinkedList::createNode($to_be_inserted_at_end));
        self::$singlyLinkedList->traverse(function (Node $currentNode) use ($to_be_inserted_at_end) {
            if ($currentNode->getNext() === null) {
                $this->assertEquals($to_be_inserted_at_end, $currentNode->getData());
            }
        });

        // * Inserting as the second element
        self::$singlyLinkedList->insertAfter(
            $to_be_inserted_at_beginning,
            SinglyLinkedList::createNode($to_be_inserted_after)
        );
        $this->assertEquals($to_be_inserted_at_beginning, self::$singlyLinkedList->getHead()->getData());
        $this->assertEquals($to_be_inserted_after, self::$singlyLinkedList->getHead()->getNext()->getData());

        // ** Inserting as the last element
        self::$singlyLinkedList->insertAfter(
            $to_be_inserted_at_end,
            SinglyLinkedList::createNode($to_be_inserted_after)
        );
        self::$singlyLinkedList->traverse(function (Node $currentNode) use ($to_be_inserted_after) {
            if ($currentNode->getNext() === null) {
                $this->assertEquals($to_be_inserted_after, $currentNode->getData());
            }
        });

        self::$singlyLinkedList->insertAfter(
            self::NON_EXISTENT_NODE_VALUE,
            SinglyLinkedList::createNode($to_be_inserted_after)
        );
    }

    /**
     * @throws EmptyLinkedList
     */
    public function testWellPopulatedSinglyLinkedListNodePrint()
    {
        $printed_singly_linked_list = self::$singlyLinkedList->print(true);
        $this->assertIsString($printed_singly_linked_list);
        $this->assertNotEmpty($printed_singly_linked_list);
        $this->expectOutputString("$printed_singly_linked_list\n");

        $this->assertNull(self::$singlyLinkedList->print());
    }

    /**
     * @throws EmptyLinkedList
     * @throws NodeNotFoundInLinkedList
     */
    public function testSinglyLinkedListNodeRemovals()
    {
        $printed_singly_linked_list = self::$singlyLinkedList->print(true);
        $singly_linked_list_data_list = explode('->', $printed_singly_linked_list);

        // Second and last elements must have the same data due to * and **
        $this->assertEquals($singly_linked_list_data_list[1], $singly_linked_list_data_list[5]);

        // Removing after the only duplicated value should take out the Node with index 2
        // because the search method will return the first Node with data equals to this value
        self::$singlyLinkedList->removeAfter((int)$singly_linked_list_data_list[1]);
        $this->assertNotEquals(
            (int)$singly_linked_list_data_list[2],
            self::$singlyLinkedList->getHead()  // 0
                ->getNext()                     // 1
                ->getNext()                     // 2
                ->getData()
        );

        // Let's remove the first Node found with duplicated value
        self::$singlyLinkedList->removeAfter((int)$singly_linked_list_data_list[0]);
        // Now it lasts only the last Node with that value

        // Calling it again shouldn't change structure as we have no value after the last node
        $printed_singly_linked_list_before = self::$singlyLinkedList->print(true);
        self::$singlyLinkedList->removeAfter((int)$singly_linked_list_data_list[1]);
        $printed_singly_linked_list_after = self::$singlyLinkedList->print(true);
        $this->assertEquals($printed_singly_linked_list_before, $printed_singly_linked_list_after);
    }
}
<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TNCPHP\DataStructures\LinkedLists\BaseLinkedList;
use TNCPHP\DataStructures\LinkedLists\SinglyLinkedList;
use TNCPHP\Exceptions\EmptyLinkedList;
use TNCPHP\Exceptions\NodeNotFoundInLinkedList;
use TNCPHP\MinorComponents\Nodes\Node;

final class SinglyLinkedListTest extends TestCase
{
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
                    self::$singlyLinkedList->search(rand());
                }
            }
        }
    }
}
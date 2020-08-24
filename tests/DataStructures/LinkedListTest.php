<?php declare(strict_types=1);

namespace Tests\DataStructures;

use PHPUnit\Framework\TestCase;
use TNCPHP\DataStructures\LinkedList;

final class LinkedListTest extends TestCase
{
    public function testExample(): void
    {
        $this->assertTrue((bool)(new LinkedList));
    }
}
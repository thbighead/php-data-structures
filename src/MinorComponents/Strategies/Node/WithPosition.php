<?php

namespace TNCPHP\MinorComponents\Strategies\Node;

use TNCPHP\MinorComponents\Node;

/**
 * Adds position to Nodes
 */
trait WithPosition
{
    /** @var int $position */
    protected $position;

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param Node|WithPosition|null $next
     *
     * @return Node|WithPosition
     */
    public function setNext(Node $next)
    {
        $next->position = $this->position + 1;
        $this->next = $next;

        return $this;
    }
}
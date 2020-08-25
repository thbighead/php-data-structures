<?php

namespace TNCPHP\MinorComponents\Strategies\Node;

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
}
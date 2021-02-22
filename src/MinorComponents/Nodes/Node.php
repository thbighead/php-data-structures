<?php

namespace TNCPHP\MinorComponents\Nodes;

class Node extends BaseNode
{
    private $next;

    public function __construct($data, Node $next = null)
    {
        parent::__construct($data);
        $this->next = $next;
    }

    /**
     * @return Node|null
     */
    public function getNext(): ?Node
    {
        return $this->next;
    }

    /**
     * @param Node|null $next
     */
    public function setNext(?Node $next): void
    {
        $this->next = $next;
    }
}
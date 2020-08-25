<?php

namespace TNCPHP\MinorComponents;

use TNCPHP\MinorComponents\Strategies\Node\WithPosition;

class NodeWithPosition extends Node
{
    use WithPosition;

    public function __construct($data = null)
    {
        parent::__construct($data);

        $this->position = 0;
    }
}
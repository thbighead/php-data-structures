<?php

namespace TNCPHP\MinorComponents;

/**
 * A classic node of data structure
 *
 * @property mixed $data
 * @property Node $next
 */
class Node
{
    private $data;
    private $next;

    public function __construct($data = null)
    {
        $this->data = $data;
        $this->next = null;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return Node
     */
    public function getNext(): Node
    {
        return $this->next;
    }

    /**
     * @param mixed $data
     * @return Node
     */
    public function setData($data): Node
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param Node $next
     * @return Node
     */
    public function setNext(Node $next): Node
    {
        $this->next = $next;

        return $this;
    }
}
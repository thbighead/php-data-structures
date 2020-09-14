<?php

namespace TNCPHP\DataStructures\LinkedLists;

use TNCPHP\DataStructures\LinkedLists\Exceptions\SearchValueNotFoundException;
use TNCPHP\MinorComponents\Node;

/**
 * Class SinglyLinkedList
 */
class SinglyLinkedList extends GenericLinkedList
{
    /**
     * @param mixed $dataSearch
     *
     * @return Node|null
     * @throws SearchValueNotFoundException
     */
    public function searchByNodeData($dataSearch)
    {
        foreach ($this as $key => $node) {
            if ($this->compareCurrentNodeData($dataSearch)) {
                return $node;
            }
        }

        throw new SearchValueNotFoundException($dataSearch);
    }

    /**
     * @param mixed $dataSearch
     *
     * @return Node[]|null
     * @throws SearchValueNotFoundException
     */
    public function searchByNodeDataWithParent($dataSearch)
    {
        $parentNode = null;

        foreach ($this as $key => $node) {
            if ($this->compareCurrentNodeData($dataSearch)) {
                return [$parentNode, $node];
            }

            $parentNode = $node;
        }

        throw new SearchValueNotFoundException($dataSearch);
    }

    /**
     * @param mixed $dataSearch
     *
     * @return $this
     * @throws SearchValueNotFoundException
     */
    public function removeByNodeData($dataSearch)
    {
        list($parentNode, $foundNode) = $this->searchByNodeDataWithParent($dataSearch);
        $data_comparing_result = $this->compareCurrentNodeData($dataSearch);

        if ($data_comparing_result && !$parentNode) {
            $this->head = $this->head->getNext();
            unset($foundNode);
            return $this;
        }

        if ($data_comparing_result) {
            $parentNode->setNext($foundNode->getNext());
            unset($foundNode);
            return $this;
        }

        throw new SearchValueNotFoundException($dataSearch);
    }
}
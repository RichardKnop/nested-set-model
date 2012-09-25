<?php

class NestedSetModel
{
    private $_nodes;
    
    public function __construct(array $nodes)
    {
        $this->_nodes = $nodes;
    }
    
    public function getNodes()
    {
        return $this->_nodes;
    }
    
    public function addNodeFromRight($parentId)
    {
        $parent = clone $this->_getNodeById($parentId);
        
        foreach ($this->_nodes as $node) {
            if ($node->rgt >= $parent->rgt) {
                $node->rgt += 2;
                if (1 !== $node->lft && $node->lft > $parent->lft) {
                    $node->lft += 2;
                }
            }
        }
        
        $numberOfChildren = ($parent->rgt - $parent->lft - 1) / 2;
        $lft = $parent->lft + $numberOfChildren * 2 + 1;
        $rgt = $lft + 1;
        $this->_nodes[] = new NestedSetModelNode($this->_getMaxId()+1, $lft, $rgt);
    }
    
    public function removeNode($id)
    {
        $nodeToRemove = $this->_getNodeById($id);
        
        if (1 !== $nodeToRemove->lft) {
            
            foreach ($this->_nodes as $node) {
                if ($node->rgt > $nodeToRemove->rgt) {
                    $node->rgt -= 2;
                    if (1 !== $node->lft && $node->lft > $nodeToRemove->lft) {
                        $node->lft -= 2;
                    }
                }
                if ($node->rgt < $nodeToRemove->rgt && $node->lft > $nodeToRemove->lft) {
                    $node->lft--;
                    $node->rgt--;
                }
            }
            
            $this->_removeNodeById($nodeToRemove->id);
        }
    }
    
    private function _getNodeById($id)
    {
        foreach ($this->_nodes as $node) {
            if ($id === $node->id) {
                return $node;
            }
        }
    }
    
    private function _getMaxId()
    {
        $ids = array();
        foreach ($this->_nodes as $node) {
            $ids[] = $node->id;
        }
        return max($ids);
    }
    
    private function _removeNodeById($id)
    {
        $newNodes = array();
        foreach ($this->_nodes as $node) {
            if ($node->id <> $id) {
                $newNodes[] = $node;
            }
        }
        $this->_nodes = $newNodes;
    }
}

class NestedSetModelNode
{
    public $id;
    public $lft;
    public $rgt;
    
    public function __construct($id, $lft, $rgt)
    {
        $this->id = $id;
        $this->lft = $lft;
        $this->rgt = $rgt;
    }
}
<?php

require_once __DIR__ . '/../NestedSetModel.php';

class NestedSetModelTest extends PHPUnit_Framework_TestCase
{
    public function testAddNodeFromRight()
    {
        $nestedSetModel = new NestedSetModel($this->_getMockNodes());
        $nestedSetModel->addNodeFromRight(4);
        $expected = array(
            new NestedSetModelNode(1, 1, 14),
            new NestedSetModelNode(2, 2, 3),
            new NestedSetModelNode(3, 4, 11),
            new NestedSetModelNode(4, 5, 8),
            new NestedSetModelNode(5, 9, 10),
            new NestedSetModelNode(6, 12, 13),
            new NestedSetModelNode(7, 6, 7),
        );
        $this->assertEquals($expected, $nestedSetModel->getNodes());
    }

    public function testRemoveNode()
    {
        $nestedSetModel = new NestedSetModel($this->_getMockNodes());
        $nestedSetModel->removeNode(3);
        $expected = array(
            new NestedSetModelNode(1, 1, 10),
            new NestedSetModelNode(2, 2, 3),
            new NestedSetModelNode(4, 4, 5),
            new NestedSetModelNode(5, 6, 7),
            new NestedSetModelNode(6, 8, 9),
        );
        $this->assertEquals($expected, $nestedSetModel->getNodes());
    }
    
    private function _getMockNodes()
    {
        return array(
            new NestedSetModelNode(1, 1, 12),
            new NestedSetModelNode(2, 2, 3),
            new NestedSetModelNode(3, 4, 9),
            new NestedSetModelNode(4, 5, 6),
            new NestedSetModelNode(5, 7, 8),
            new NestedSetModelNode(6, 10, 11),
        );
    }
}
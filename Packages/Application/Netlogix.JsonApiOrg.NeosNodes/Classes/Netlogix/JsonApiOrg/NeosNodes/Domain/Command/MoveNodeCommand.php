<?php
namespace Netlogix\JsonApiOrg\NeosNodes\Domain\Command;

/*
 * This file is part of the Netlogix.JsonApiOrg.NeosNodes package.
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

class MoveNodeCommand extends AbstractCommand
{
    /**
     * @var NodeInterface
     */
    protected $node;

    /**
     * @var NodeInterface
     */
    protected $targetNode;

    /**
     * @var string
     */
    protected $position;

    /**
     * @param NodeInterface $node
     * @param NodeInterface $targetNode
     * @param string $position
     */
    public function __construct(NodeInterface $node, NodeInterface $targetNode, $position)
    {
        parent::__construct();
        $this->node = $node;
        $this->targetNode = $targetNode;
        $this->position = $position;
    }

    /**
     *
     */
    public function execute()
    {
    }

    /**
     * @return NodeInterface
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @return NodeInterface
     */
    public function getTargetNode()
    {
        return $this->targetNode;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }
}
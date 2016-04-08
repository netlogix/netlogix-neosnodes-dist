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

class CreateNodeCommand extends AbstractCommand
{
    /**
     * @var NodeInterface
     */
    protected $parent;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param NodeInterface $node
     * @param string $type
     */
    public function __construct(NodeInterface $parent, $type)
    {
        parent::__construct();
        $this->parent = $parent;
        $this->type = $type;
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
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

}
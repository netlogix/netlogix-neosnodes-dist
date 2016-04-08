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

class PublishNodesCommand extends AbstractPublishCommand
{

    /**
     * @var array<NodeInterface>
     */
    protected $nodes;

    /**
     * @param string $targetWorkspaceName
     * @param array <NodeInterface> $nodes
     */
    public function __construct($targetWorkspaceName, array $nodes)
    {
        parent::__construct($targetWorkspaceName);
        $this->nodes = $nodes;
    }

    /**
     *
     */
    public function execute()
    {
    }

    /**
     * @return array<NodeInterface>
     */
    public function getNodes()
    {
        return $this->nodes;
    }

}
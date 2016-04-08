<?php
namespace Netlogix\JsonApiOrg\NeosNodes\Domain\Dto;

/*
 * This file is part of the Netlogix.JsonApiOrg.NeosNodes package.
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use Netlogix\JsonApiOrg\Resource\Information\ResourceInformation;
use Netlogix\JsonApiOrg\Resource\Information\ResourceInformationInterface;

/**
 * @Flow\Scope("singleton")
 */
class NodeResourceInformation extends ResourceInformation implements ResourceInformationInterface
{

    /**
     * @var string
     */
    protected $controllerName = 'Node';

    /**
     * @var string
     */
    protected $packageKey = 'Netlogix.JsonApiOrg.NeosNodes';

    /**
     * @var string
     */
    protected $resourceClassName = NodeResource::class;

    /**
     * @var string
     */
    protected $payloadClassName = NodeInterface::class;

    /**
     * @inheritdoc
     */
    protected function getResourceControllerArguments($node)
    {
        return array(
            'node' => $node,
        );
    }

    /**
     * @inheritdoc
     */
    protected function getRelationshipControllerArguments($node, $relationshipName)
    {
        return array(
            'node' => $node,
            'relationshipName' => $relationshipName
        );
    }

}
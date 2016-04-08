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
use Netlogix\JsonApiOrg\NeosNodes\Domain\Command\AbstractCommand;
use Netlogix\JsonApiOrg\Resource\Information\ResourceInformation;
use Netlogix\JsonApiOrg\Resource\Information\ResourceInformationInterface;

/**
 * @Flow\Scope("singleton")
 */
class CommandResourceInformation extends ResourceInformation implements ResourceInformationInterface
{

    /**
     * @var string
     */
    protected $controllerName = 'Command';

    /**
     * @var string
     */
    protected $packageKey = 'Netlogix.JsonApiOrg.NeosNodes';

    /**
     * @var string
     */
    protected $resourceClassName = CommandResource::class;

    /**
     * @var string
     */
    protected $payloadClassName = AbstractCommand::class;

    /**
     * @inheritdoc
     */
    protected function getResourceControllerArguments($command)
    {
        return array(
            'command' => $command,
        );
    }

    /**
     * @inheritdoc
     */
    protected function getRelationshipControllerArguments($command, $relationshipName)
    {
        return array(
            'command' => $command,
            'relationshipName' => $relationshipName
        );
    }

}
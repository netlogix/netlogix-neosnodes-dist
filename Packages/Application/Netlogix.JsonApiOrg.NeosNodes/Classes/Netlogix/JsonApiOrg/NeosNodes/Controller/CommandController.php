<?php
namespace Netlogix\JsonApiOrg\NeosNodes\Controller;

/*
 * This file is part of the Netlogix.JsonApiOrg.NeosNodes package.
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use TYPO3\Flow\Annotations as Flow;
use Netlogix\Cqrs\Command\CommandBus;
use Netlogix\JsonApiOrg\Controller\ApiController;
use Netlogix\JsonApiOrg\NeosNodes\Domain\Command\AbstractCommand;
use TYPO3\Flow\Reflection\ObjectAccess;

class CommandController extends ApiController
{

    /**
     * @var string
     */
    protected $resourceArgumentName = 'command';

    /**
     * @var CommandBus
     * @Flow\Inject
     */
    protected $commandBus;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param AbstractCommand $command
     */
    public function createAction(AbstractCommand $command)
    {
        $this->commandBus->delegate($command);
        $topLevel = $this->relationshipIterator->createTopLevel($command);
        $location = ObjectAccess::getPropertyPath($topLevel->jsonSerialize(), 'data.links.self');

        $this->view->assign('value', $topLevel);

        $this->response->setStatus(201);
        $this->response->setHeader('Location', $location);
    }

}
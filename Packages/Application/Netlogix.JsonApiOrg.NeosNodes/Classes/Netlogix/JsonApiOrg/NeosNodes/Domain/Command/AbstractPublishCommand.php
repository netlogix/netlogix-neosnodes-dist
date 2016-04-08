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

class AbstractPublishCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $targetWorkspaceName;

    /**
     * @param string $targetWorkspaceName
     */
    public function __construct($targetWorkspaceName) {
        parent::__construct();
        $this->targetWorkspaceName = $targetWorkspaceName;
    }

    /**
     *
     */
    public function execute()
    {
    }

    /**
     * @return string
     */
    public function getTargetWorkspaceName()
    {
        return $this->targetWorkspaceName;
    }

}
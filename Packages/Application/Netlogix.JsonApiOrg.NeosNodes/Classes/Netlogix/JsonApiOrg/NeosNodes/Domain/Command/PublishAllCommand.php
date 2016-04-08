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

class PublishAllCommand extends AbstractPublishCommand
{

    /**
     * @var string
     */
    protected $sourceWorkspaceName;

    /**
     * @param string $targetWorkspaceName
     * @param string $sourceWorkspaceName
     */
    public function __construct($targetWorkspaceName, $sourceWorkspaceName)
    {
        parent::__construct($targetWorkspaceName);
        $this->sourceWorkspaceName = $sourceWorkspaceName;
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
    public function getSourceWorkspaceName()
    {
        return $this->sourceWorkspaceName;
    }

}
<?php
namespace Netlogix\JsonApiOrg\NeosNodes\TypeConverter;

/*
 * This file is part of the Netlogix.JsonApiOrg.NeosNodes package.
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use TYPO3\Flow\Annotations as Flow;
use Netlogix\JsonApiOrg\Property\TypeConverter\Entity\PersistentObjectConverter;

class NodePersistentObjectConverter extends PersistentObjectConverter
{
    /**
     * @var string
     */
    protected $targetType = 'TYPO3\\TYPO3CR\\Domain\\Model\\NodeInterface';

    /**
     * @var integer
     */
    protected $priority = 1460121701;

}
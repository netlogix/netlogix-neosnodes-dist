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
use TYPO3\Flow\Property\PropertyMappingConfigurationInterface;
use Netlogix\JsonApiOrg\Property\TypeConverter\Entity\PersistentObjectConverter;

class CommandConverter extends PersistentObjectConverter
{
    /**
     * @var string
     */
    protected $targetType = 'Netlogix\\Cqrs\\Command\\Command';
    /**
     * @var integer
     */
    protected $priority = 1460043483;

    /**
     * @inheritdoc
     */
    public function convertFrom($source, $targetType, array $convertedChildProperties = array(), PropertyMappingConfigurationInterface $configuration = null)
    {
        return parent::convertFrom($source, $targetType, $convertedChildProperties, $configuration);
    }

}
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
use TYPO3\TYPO3CR\Domain\Model\Node;
use Netlogix\JsonApiOrg\NeosNodes\Domain\Dto\NodeResource;
use Netlogix\JsonApiOrg\Property\TypeConverter\SchemaResource\ResourceConverter;
use Netlogix\JsonApiOrg\Resource\Information\ResourceMapper;

class NodeResourceConverter extends ResourceConverter
{
    /**
     * @var ResourceMapper
     * @Flow\Inject
     */
    protected $resourceMapper;

    /**
     * The target type this converter can convert to.
     *
     * @var string
     * @api
     */
    protected $targetType = 'Netlogix\\JsonApiOrg\\NeosNodes\\Domain\\Dto\\NodeResource';

    /**
     * @inheritdoc
     */
    public function convertFrom($source, $targetType = null, array $subProperties = array(), PropertyMappingConfigurationInterface $configuration = null)
    {
        $node = $this->propertyMapper->convert($source, Node::class, $configuration);
        if (!($node instanceof Node)) {
            return $node;
        }

        $resourceInformation = $this->resourceMapper->findResourceInformation($node);
        return $this->objectManager->get(NodeResource::class, $node, $resourceInformation);
    }
}
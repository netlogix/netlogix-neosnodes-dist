<?php
namespace Netlogix\JsonApiOrg\NeosNodes\Configuration;

/*
 * This file is part of the Netlogix.JsonApiOrg.NeosNodes package.
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class ConfigurationProvider
{

    /**
     * @var array
     * @Flow\InjectConfiguration(package="Netlogix.JsonApiOrg.NeosNodes", path="exposingConfiguration")
     */
    protected $exposingConfiguration = [];

    /**
     * @var array
     */
    protected $runtimeCache = [];

    /**
     * @param mixed $objectOrObjectType
     * @return array|null
     */
    public function getSettingsForType($objectOrObjectType)
    {
        if (is_object($objectOrObjectType)) {
            $objectOrObjectType = get_class($objectOrObjectType);
        }
        if (!array_key_exists($objectOrObjectType, $this->runtimeCache)) {
            $this->runtimeCache[$objectOrObjectType] = $this->generateSettingsForType($objectOrObjectType);
        }

        return $this->runtimeCache[$objectOrObjectType];
    }

    /**
     * @param string $type
     * @return array|null
     */
    protected function generateSettingsForType($type)
    {
        if (!$type) {
            return null;
        } elseif (isset($this->exposingConfiguration[$type])) {
            return $this->exposingConfiguration[$type];
        } else {
            return $this->getSettingsForType(get_parent_class($type));
        }
    }

}
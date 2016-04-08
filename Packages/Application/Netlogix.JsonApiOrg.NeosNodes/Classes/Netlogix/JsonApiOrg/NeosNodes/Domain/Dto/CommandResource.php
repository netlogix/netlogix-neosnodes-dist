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
use Netlogix\JsonApiOrg\Domain\Dto\AbstractResource;
use Netlogix\JsonApiOrg\NeosNodes\Configuration\ConfigurationProvider;
use Netlogix\JsonApiOrg\NeosNodes\Domain\Command\AbstractCommand;
use Netlogix\JsonApiOrg\Resource\Information\ResourceInformationInterface;
use Netlogix\JsonApiOrg\Schema\Relationships;
use Netlogix\JsonApiOrg\Schema\ResourceInterface;

class CommandResource extends AbstractResource implements ResourceInterface
{

    /**
     * @var AbstractCommand
     */
    protected $payload;

    /**
     * @var ConfigurationProvider
     * @Flow\Inject
     */
    protected $configurationProvider;

    /**
     * @var array<string>
     */
    protected $attributesToBeApiExposed = [];

    /**
     * @var array<string>
     */
    protected $relationshipsToBeApiExposed = [];

    /**
     * @param AbstractCommand $payload
     * @param ResourceInformationInterface $converter
     */
    public function __construct(AbstractCommand $payload, ResourceInformationInterface $converter)
    {
        parent::__construct($payload, $converter);
    }

    /**
     * One way of configuring the toBeApiExposed is putting them into settings.
     */
    public function initializeObject()
    {
        $settings = $this->configurationProvider->getSettingsForType($this->getPayload());
        $this->attributesToBeApiExposed = $settings['attributesToBeApiExposed'];
        $this->relationshipsToBeApiExposed = $settings['relationshipsToBeApiExposed'];
    }

    /**
     * @return AbstractCommand
     */
    public function getPayload()
    {
        return parent::getPayload();
    }

    /**
     * @inheritdoc
     */
    public function setPayloadProperty($propertyName, $value)
    {
        return parent::setPayloadProperty($propertyName, $value);
    }

}

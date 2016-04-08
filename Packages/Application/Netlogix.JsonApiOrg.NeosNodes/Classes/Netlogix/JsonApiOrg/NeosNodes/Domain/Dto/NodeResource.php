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
use TYPO3\Eel\EelEvaluatorInterface;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use Netlogix\JsonApiOrg\Domain\Dto\AbstractResource;
use Netlogix\JsonApiOrg\Resource\Information\ResourceInformationInterface;
use Netlogix\JsonApiOrg\Schema\Relationships;
use Netlogix\JsonApiOrg\Schema\ResourceInterface;

class NodeResource extends AbstractResource implements ResourceInterface
{

    /**
     * @var NodeInterface
     */
    protected $payload;

    /**
     * @var EelEvaluatorInterface
     * @Flow\Inject
     */
    protected $eelEvaluator;

    /**
     * @var array<string>
     */
    protected $attributesToBeApiExposed = [];

    /**
     * @var array<string>
     */
    protected $relationshipsToBeApiExposed = [];

    /**
     * Resource constructor.
     *
     * @param NodeInterface $payload
     * @param ResourceInformationInterface $converter
     */
    public function __construct(NodeInterface $payload, ResourceInformationInterface $converter)
    {
        parent::__construct($payload, $converter);
    }

    /**
     * There's no need to put configuration for nodes into settings because all information is part of the
     * $payload Node object.
     *
     * Skipping "image" and "chapterImage" is required unless we have distinct Resource and ResourceInformation
     * for file classes or at least image classes.
     */
    public function initializeObject()
    {
        $this->attributesToBeApiExposed = $this->getPayload()->getPropertyNames();
        $this->attributesToBeApiExposed = array_filter($this->attributesToBeApiExposed, function ($input) {
            switch ($input) {
                case 'image':
                case 'chapterImage':
                    return false;
                default:
                    return true;
            }
        });
        $this->attributesToBeApiExposed[] = '_index';
        $this->attributesToBeApiExposed[] = '_hidden';
        $this->attributesToBeApiExposed[] = '_workspace';
        $this->attributesToBeApiExposed[] = '_creationDateTime';

        $this->relationshipsToBeApiExposed = [
            'childNodes' => Relationships::RELATIONSHIP_TYPE_COLLECTION,
            'parent' => Relationships::RELATIONSHIP_TYPE_SINGLE,
            'parents' => Relationships::RELATIONSHIP_TYPE_COLLECTION,
        ];
    }

    /**
     * @return NodeInterface
     */
    public function getPayload()
    {
        return parent::getPayload();
    }

    /**
     * Usually the type is just the class name of the object.
     * Because nodes have a type themselves, the result of this method contains both, the "Node" prefix as well as
     * the internal type name.
     *
     * @inheritdoc
     */
    public function getType()
    {
        return 'TYPO3CR\\Node(' . $this->getPayload()->getNodeType()->getName() . ')';
    }

    /**
     * Usually the id is the persistence object identifier.
     * Becasue nodes are identified by their context path holding both, the node path, the worskpace and the dimensions
     * collection, using the context path is way better for nodes.
     *
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPayload()->getContextPath();
    }

    /**
     * This should avoid using this as a write api.
     *
     * @inheritdoc
     * @throws \TYPO3\TYPO3CR\Exception\NodeException
     */
    public function setPayloadProperty($propertyName, $value)
    {
        if ($this->getPayloadProperty($propertyName) === $value) {
            return;
        }
        throw new \TYPO3\TYPO3CR\Exception\NodeException('This is not a write API.', 1459954699);
    }

    /**
     * Here we deal with all kinds of property mapping. Some attributes are taken from the payload object, some
     * are taken from the payloads data array and others are completely virtual.
     *
     * @inheritdoc
     */
    public function getPayloadProperty($propertyName)
    {
        switch ($propertyName) {
            case '_index':
                return $this->getPayload()->getIndex();
            case '_hidden':
                return $this->getPayload()->isHidden();
            case '_workspace':
                return $this->getPayload()->getWorkspace()->getName();
            case '_creationDateTime':
                return $this->getPayload()->getNodeData()->getCreationDateTime()->format('r');
            case 'parents':
                return $this->getNodesByEelExpression('${q(node).add(q(node).parents("[instanceof TYPO3.Neos:Document]")).get()}');
        }

        if (in_array($propertyName, $this->attributesToBeApiExposed)) {
            return $this->getPayload()->getProperty($propertyName);
        }

        return parent::getPayloadProperty($propertyName);
    }

    /**
     * Use some Eel expression, such as "${q(node).add(q(node).parents('[instanceof TYPO3.Neos:Document]')).get()}"
     * for breadcrumb.
     *
     * @see \TYPO3\Eel\Utility::evaluateEelExpression
     * @param $expression
     * @return array
     */
    protected function getNodesByEelExpression($expression)
    {
        return \TYPO3\Eel\Utility::evaluateEelExpression($expression, $this->eelEvaluator, array('node' => $this->getPayload()));
    }

}

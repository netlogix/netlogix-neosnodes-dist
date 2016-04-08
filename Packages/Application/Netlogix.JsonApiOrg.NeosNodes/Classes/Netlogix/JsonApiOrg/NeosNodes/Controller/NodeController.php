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
use TYPO3\Eel\FlowQuery\FlowQuery;
use TYPO3\TYPO3CR\Domain\Model\Node;
use Netlogix\JsonApiOrg\Controller\ApiController;
use Netlogix\JsonApiOrg\NeosNodes\Domain\Dto\NodeResource;

class NodeController extends ApiController
{
    use \TYPO3\Neos\Controller\CreateContentContextTrait;

    /**
     * @var \TYPO3\Eel\EelEvaluatorInterface
     * @Flow\Inject(lazy=false)
     */
    protected $eelEvaluator;

    /**
     * @var string
     */
    protected $resourceArgumentName = 'node';

    /**
     * @todo: Discuss search feature.
     *
     * I'm not completely sure about how powerfull the "filter" mechanism should be. Since the expression is present
     * as a string here, the filter *could* be an actual Eel query as well, providing the full power of FlowQuery
     * to the world. But I really don't know if that's the kind of flexibility an API consumer should have.
     *
     * @param array $filter
     */
    public function listAction($filter = [])
    {
        $site = $this->_siteRepository->findFirstOnline();
        $contentContext = $this->createContentContext('live', []);
        $rootNode = $contentContext->getNode('/sites/' . $site->getNodeName());

        $type = isset($filter['type']) ? $filter['type'] : 'TYPO3.Neos:Document';
        $expression = '${q(node).parent().find("[instanceof ' . $type . ']").get()}';
        $results = \TYPO3\Eel\Utility::evaluateEelExpression($expression, $this->eelEvaluator, array('node' => $rootNode));

        $topLevel = $this->relationshipIterator->createTopLevel($results);
        $this->view->assign('value', $topLevel);
    }

    /**
     * @param Node $node
     */
    public function showAction(Node $node)
    {
        $topLevel = $this->relationshipIterator->createTopLevel($node);
        $this->view->assign('value', $topLevel);
    }

    /**
     * @param NodeResource $node
     * @param string $relationshipName
     */
    public function showRelationshipAction(NodeResource $node, $relationshipName)
    {
        $relationship = \TYPO3\Flow\Reflection\ObjectAccess::getProperty($node->getRelationships(), $relationshipName);
        $this->view->assign('value', $relationship);
    }

    /**
     * @param NodeResource $node
     * @param string $relationshipName
     */
    public function showRelatedAction(NodeResource $node, $relationshipName)
    {
        $relationship = $node->getPayloadProperty($relationshipName);
        $topLevel = $this->relationshipIterator->createTopLevel($relationship);
        $this->view->assign('value', $topLevel);
    }

    /**
     * @param Node $node
     * @throws \TYPO3\TYPO3CR\Exception\NodeException
     */
    public function createAction(Node $node)
    {
        throw new \TYPO3\TYPO3CR\Exception\NodeException('Nodes are not to be created CURDy', 1459875228);
    }

    /**
     * @param Node $node
     * @throws \TYPO3\TYPO3CR\Exception\NodeException
     */
    public function createRelationshipAction(Node $node)
    {
        throw new \TYPO3\TYPO3CR\Exception\NodeException('Nodes are not to be updated CURDy', 1459875228);
    }


    /**
     * @param Node $node
     * @throws \TYPO3\TYPO3CR\Exception\NodeException
     */
    public function updateAction(Node $node)
    {
        throw new \TYPO3\TYPO3CR\Exception\NodeException('Nodes are not to be updated CURDy', 1459875246);
    }

    /**
     * @param Node $node
     * @param $relationshipName
     * @throws \TYPO3\TYPO3CR\Exception\NodeException
     */
    public function updateRelationshipAction(Node $node, $relationshipName)
    {
        throw new \TYPO3\TYPO3CR\Exception\NodeException('Nodes are not to be updated CURDy', 1459875253);
    }

    /**
     * @param Node $node
     * @throws \TYPO3\TYPO3CR\Exception\NodeException
     */
    public function deleteAction(Node $node)
    {
        throw new \TYPO3\TYPO3CR\Exception\NodeException('Nodes are not to be deleted CURDy', 1459875259);
    }

    /**
     * @param Node $node
     * @param $relationshipName
     * @throws \TYPO3\TYPO3CR\Exception\NodeException
     */
    public function deleteRelationshipAction(Node $node, $relationshipName)
    {
        throw new \TYPO3\TYPO3CR\Exception\NodeException('Nodes are not to be deleted CURDy', 1459875266);
    }

}
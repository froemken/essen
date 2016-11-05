<?php

namespace StefanFroemken\Essen\SignalSlot;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use StefanFroemken\Essen\Domain\Model\Food;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\Comparison;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\PropertyValue;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ModifyQuery
{
    /**
     * Reduce query result
     *
     * @param Query $query
     *
     * @return array
     */
    public function reduceResultSet(Query $query)
    {
        // only reduce query for given pageUid and if query is related to Food models
        if (
            $this->getTypoScriptFrontendController()->id === 7 &&
            $query->getType() === Food::class
        ) {
            /** @var Comparison $constraints */
            $constraints = $query->getConstraint();
            if ($constraints instanceof Comparison) {
                /** @var PropertyValue $property */
                $property = $constraints->getOperand1();
                if (
                    $property->getPropertyName() === 'uid' &&
                    $property->getSelectorName() === 'tx_essen_domain_model_food'
                ) {
                    // detail view. Do nothing
                } elseif ($property->getSelectorName() === 'tx_essen_domain_model_food') {
                    // listAction doesn't work with findAll
                    // The resultSet was reduced in Repo or in Controller
                    // We have to add our condition to the existing ones
                    $matchings = array();
                    $matchings[] = $constraints;
                    $matchings[] = $query->like('title', '%auflauf%');
                    $query->matching($query->logicalAnd($matchings))->execute();
                }
            } else {
                // comparison is empty. We can start a new matching
                $query->matching($query->like('title', '%auflauf%'))->execute();
            }
        }
        if (
            $this->getTypoScriptFrontendController()->id === 8 &&
            $query->getType() === Food::class
        ) {
            // allow hidden records
            $query->getQuerySettings()->setEnableFieldsToBeIgnored(array('disabled'));
            $query->getQuerySettings()->setIgnoreEnableFields(true);
        }
        return array($query);
    }
    
    /**
     * Get TSFE
     *
     * @return TypoScriptFrontendController
     */
    public function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
    
    /**
     * Get TYPO3s Database Connection
     *
     * @return DatabaseConnection
     */
    public function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}

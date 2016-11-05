<?php
namespace StefanFroemken\Essen\Dispatch;

/**
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
use StefanFroemken\Essen\Ajax\AbstractAjaxRequest;
use TYPO3\CMS\Core\Http\AjaxRequestHandler;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class AjaxRequest
 *
 * @category Dispatch
 * @package  Essen
 */
class AjaxRequest
{
    /**
     * objectManager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * Constructor of this class
     */
    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    }

    /**
     * dispatcher for ajax requests
     *
     * @param array $parameters
     * @param AjaxRequestHandler $ajaxObj
     *
     * @return bool
     */
    public function dispatch(array $parameters, AjaxRequestHandler $ajaxObj)
    {
        /** @var ServerRequest $request */
        $request = $parameters['request'];
        $queryParameters = $request->getQueryParams()['tx_essen_food'];
        $className = 'StefanFroemken\\Essen\\Ajax\\' . $queryParameters['objectName'];
        if (class_exists($className)) {
            /** @var AbstractAjaxRequest $object */
            $object = $this->objectManager->get($className);
            if (method_exists($object, 'processAjaxRequest')) {
                $result = $object->processAjaxRequest($queryParameters['arguments']);
                $ajaxObj->setContent(array($result));
                return true;
            }
        }
        return false;
    }
}

<?php
namespace StefanFroemken\Essen\Ajax;

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
use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Extbase\Reflection\PropertyReflection;

/**
 * Class AbstractAjaxRequest
 *
 * @category Ajax
 * @package  Essen
 */
abstract class AbstractAjaxRequest implements AjaxInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @var BackendConfigurationManager
     */
    protected $backendConfigurationManager;

    /**
     * inject objectManager
     *
     * @param ObjectManager $objectManager
     * @return void
     */
    public function injectObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * inject persistenceManager
     *
     * @param PersistenceManagerInterface $persistenceManager
     * @return void
     */
    public function injectPersistenceManager(PersistenceManagerInterface $persistenceManager
    ) {
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * inject backendConfigurationManager
     *
     * @param BackendConfigurationManager $backendConfigurationManager
     * @return void
     */
    public function injectBackendConfigurationManager(BackendConfigurationManager $backendConfigurationManager) {
        $this->backendConfigurationManager = $backendConfigurationManager;
    }

    /**
     * In Typo3QuerySettings there is a feature check which loads whole TS which needs about 250ms
     * With this workaround I modify the 1st level cache of configuration manager
     *
     * @return void
     */
    /*public function initializeObject()
    {
        // set minimal configuration
        $configuration = array();
        $configuration['_']['features']['ignoreAllEnableFieldsInBe'] = 0;

        // transport our minimal configuration into backendConfigurationManagers 1st-level Cache
        if (property_exists(get_class($this->backendConfigurationManager), 'configurationCache')) {
            $propertyReflection = new PropertyReflection(
                get_class($this->backendConfigurationManager),
                'configurationCache'
            );
            $propertyReflection->setAccessible(true);
            $propertyReflection->setValue($this->backendConfigurationManager, $configuration);
        }
    }*/
}

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
use JWeiland\Maps2\Domain\Model\Poi;
use JWeiland\Maps2\Domain\Model\PoiCollection;
use JWeiland\Maps2\Domain\Repository\PoiCollectionRepository;
use StefanFroemken\Essen\Domain\Model\Food;
use StefanFroemken\Essen\Domain\Repository\FoodRepository;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Class FindFood
 *
 * @category Ajax
 * @package  Essen
 */
class FindFood extends AbstractAjaxRequest
{
    /**
     * @var FoodRepository
     */
    protected $foodRepository;
    
    /**
     * @var ConfigurationManagerInterface
     */
    protected $configurationManager;
    
    /**
     * inject foodRepository
     *
     * @param FoodRepository $foodRepository
     * @return void
     */
    public function injectFoodRepository(FoodRepository $foodRepository)
    {
        $this->foodRepository = $foodRepository;
    }
    
    /**
     * inject configurationManager
     *
     * @param ConfigurationManagerInterface $configurationManager
     * @return void
     */
    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * process ajax request
     *
     * @param array $arguments Arguments to process
     *
     * @return string
     */
    public function processAjaxRequest(array $arguments)
    {
        /** @var Food $food */
        $food = $this->foodRepository->findByIdentifier((int)$arguments['uid']);
        if ($food instanceof Food) {
            return $food->getTitle();
        }
        return '';
    }
}

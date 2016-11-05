<?php

namespace StefanFroemken\Essen\Controller;

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
use StefanFroemken\Essen\Domain\Repository\FoodRepository;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use TYPO3\CMS\Extbase\Validation\Validator\ConjunctionValidator;
use TYPO3\CMS\Extbase\Validation\Validator\GenericObjectValidator;
use TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator;
use TYPO3\CMS\Extbase\Validation\ValidatorResolver;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FoodController extends AbstractController
{
    /**
     * @var FoodRepository
     */
    protected $foodRepository;
    
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
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $foods = $this->foodRepository->findAll();
        $this->view->assign('foods', $foods);
    }

    /**
     * action list fast
     *
     * @return void
     */
    public function listFastAction()
    {
        $foods = $this->foodRepository->findAll();
        $this->view->assign('foods', $foods);
    }
    
    /**
     * action show
     *
     * @param Food $food
     *
     * @return string
     */
    public function showAction(Food $food)
    {
        $this->view->assign('food', $food);
        $content = $this->view->render();
    
        DebugUtility::debug(ObjectAccess::getProperty($this->session, 'identifierMap', true));
    
        return $content;
    }
    
    /**
     * action showFast
     *
     * @param int $food
     *
     * @return string
     */
    public function showFastAction($food)
    {
        $foodObject = $this->foodRepository->findByIdentifier($food);
        $this->view->assign('food', $foodObject);
        $content = $this->view->render();
    
        DebugUtility::debug(ObjectAccess::getProperty($this->session, 'identifierMap', true));
        
        return $content;
    }
    
    /**
     * action modify query
     *
     * @return void
     */
    public function modifyQueryAction()
    {
        $foods = $this->foodRepository->findAll();
        /** @var Query $query */
        //$query = $foods->getQuery();
        //$foods = $query->matching($query->equals('ingredients.title', 'Käse'))->execute();
        $this->view->assign('foods', $foods);
    }
    
    /**
     * show new action
     *
     * @return void
     */
    public function newAction()
    {
        /** @var Food $food */
        $food = $this->objectManager->get(Food::class);
        $this->view->assign('food', $food);
    }
    
    /**
     * load before createAction
     *
     * @return void
     */
    public function initializeCreateAction()
    {
        /** @var ValidatorResolver $validatorResolver */
        $validatorResolver = $this->objectManager->get(ValidatorResolver::class);
        
        /** @var NotEmptyValidator $notEmptyValidator */
        $notEmptyValidator = $validatorResolver->createValidator(NotEmptyValidator::class);
        
        $foodValidator = $validatorResolver->getBaseValidatorConjunction(Food::class);
        $validators = $foodValidator->getValidators();
        $validators->rewind();
        /** @var GenericObjectValidator $genericObjectValidator */
        $genericObjectValidator = $validators->current();
        $genericObjectValidator->addPropertyValidator('price', $notEmptyValidator);
        
        /** @var ConjunctionValidator $conjunctionValidator */
        $conjunctionValidator = $this->arguments->getArgument('food')->getValidator();
        /** @var  $validator */
        foreach ($conjunctionValidator->getValidators() as $validator) {
            $conjunctionValidator->removeValidator($validator);
        }
        $conjunctionValidator->addValidator($foodValidator);
    }
    
    /**
     * Create Action
     *
     * @param Food $food
     *
     * @return void
     */
    public function createAction(Food $food)
    {
        $this->foodRepository->add($food);
        $this->redirect('list');
    }
}

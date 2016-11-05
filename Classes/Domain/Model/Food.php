<?php

namespace StefanFroemken\Essen\Domain\Model;

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
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Food extends AbstractEntity
{
    /**
     * Hidden.
     *
     * @var bool
     */
    protected $hidden = false;
    
    /**
     * Title.
     *
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';
    
    /**
     * Price
     *
     * @var string
     */
    protected $price = '';
    
    /**
     * Ingredients.
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\StefanFroemken\Essen\Domain\Model\Ingredient>
     */
    protected $ingredients;

    /**
     * Constructor of this class.
     */
    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
     */
    protected function initStorageObjects()
    {
        $this->ingredients = new ObjectStorage();
    }
    
    /**
     * Returns the hidden
     *
     * @return bool $hidden
     */
    public function getHidden()
    {
        return $this->hidden;
    }
    
    /**
     * Sets the hidden
     *
     * @param bool $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = (bool)$hidden;
    }
    
    /**
     * Returns the title.
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = (string)$title;
    }
    
    /**
     * Returns the price
     *
     * @return string $price
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Sets the price
     *
     * @param string $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = (string)$price;
    }

    /**
     * Adds a Ingredient.
     *
     * @param Ingredient $ingredient
     */
    public function addIngredient(Ingredient $ingredient)
    {
        $this->ingredients->attach($ingredient);
    }

    /**
     * Removes a Ingredient.
     *
     * @param Ingredient $ingredientToRemove The Ingredient to be removed
     */
    public function removeIngredient(Ingredient $ingredientToRemove)
    {
        $this->ingredients->detach($ingredientToRemove);
    }

    /**
     * Returns the ingredients.
     *
     * @return ObjectStorage $ingredients
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Sets the ingredients.
     *
     * @param ObjectStorage $ingredients
     */
    public function setIngredients(ObjectStorage $ingredients)
    {
        $this->ingredients = $ingredients;
    }
}

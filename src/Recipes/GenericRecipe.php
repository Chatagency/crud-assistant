<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\Recipe;

/**
 * Generic Recipe
 */
class GenericRecipe extends Recipe implements RecipeInterface
{
    /**
     * Recipe identifier
     *
     * @var string
     */
    protected $identifier;
    
    /**
     * Sets recipe identifier
     *
     * @param string $identifier
     * @return self
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }
    
}

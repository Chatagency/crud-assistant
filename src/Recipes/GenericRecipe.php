<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\Recipe;

class GenericRecipe extends Recipe implements RecipeInterface
{
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
    
    /**
     * Returns recipe identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}

<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\Recipe;

/**
 * Generic Recipe.
 */
class GenericRecipe extends Recipe implements RecipeInterface
{
    /**
     * Sets recipe identifier.
     *
     * @return self
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Sets setters array.
     *
     * @return self
     */
    public function setSetters(array $setters)
    {
        $this->setters = $setters;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\SanitationAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\Recipe;

class SanitationActionRecipe extends Recipe implements RecipeInterface
{
    /**
     * Returns recipe identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return SanitationAction::class;
    }
}

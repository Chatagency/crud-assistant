<?php

declare(strict_types=1);

namespace Chatagency\Recipes;

use Chatagency\CrudAssistant\Actions\Filter;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\Recipe;

class FilterRecipe extends Recipe implements RecipeInterface
{
    /**
     * Returns recipe identifier
     *
     * @return void
     */
    public function getIdentifier()
    {
        return Filter::class;
    }
}

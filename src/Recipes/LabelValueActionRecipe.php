<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\Recipe;

/**
 * Label Value Action Recipe
 */
class LabelValueActionRecipe extends Recipe implements RecipeInterface
{
    /**
     * Recipe identifier
     *
     * @var string
     */
    protected $identifier = LabelValueAction::class;
    
}

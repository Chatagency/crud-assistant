<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\Recipe;

/**
 * Filter Action Recipe.
 */
class FilterActionRecipe extends Recipe implements RecipeInterface
{
    /**
     * Allowed setters.
     * Ignored if empty.
     *
     * @var array
     */
    protected $setters = ['filter', 'ignoreIfEmpty', 'callback'];

    /**
     * Recipe identifier.
     *
     * @var string
     */
    protected $identifier = FilterAction::class;
}

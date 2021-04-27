<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\RecipeBase;
use Closure;

/**
 * Filter Action Recipe.
 */
class FilterRecipe extends RecipeBase implements RecipeInterface
{
    /**
     * Filter value.
     */
    public bool $filter = false;

    /**
     * Ignore if value is empty (null or empty string).
     */
    public bool $ignoreIfEmpty = false;

    /**
     * Custom filter via callback.
     */
    public Closure $callback;

    /**
     * Recipe identifier.
     *
     * @var string
     */
    protected $identifier = FilterAction::class;
}

<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\RecipeBase;

/**
 * Filter Action Recipe.
 */
final class FilterRecipe extends RecipeBase implements RecipeInterface
{
    /**
     * Recipe Action.
     *
     * @var string
     */
    protected $action = FilterAction::class;

    public function __construct(
        public bool $filter = true,
        public bool $ignoreIfEmpty = false,
        public ?\Closure $callback = null,
    ) {
    }

    public static function make(bool $filter = true, bool $ignoreIfEmpty = false, ?\Closure $callback = null): self
    {
        return new self(
            $filter,
            $ignoreIfEmpty,
            $callback
        );
    }
}

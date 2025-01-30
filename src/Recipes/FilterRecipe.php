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

    public function __construct(
        public bool $filter = true,
        public bool $ignoreIfEmpty = false,
        public Closure|null $callback = null
    ) 
    {}

    public  static function make(bool $filter = true ,bool $ignoreIfEmpty = false,Closure|null $callback = null): FilterRecipe
    {
        return new static(
            $filter,
            $ignoreIfEmpty,
            $callback
        );
    }

    /**
     * Recipe Action.
     *
     * @var string
     */
    protected $action = FilterAction::class;

}

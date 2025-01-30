<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Closure;
use Chatagency\CrudAssistant\RecipeBase;
use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;

/**
 * Label Value Action Recipe.
 */
final class LabelValueRecipe extends RecipeBase implements RecipeInterface
{
    /**
     * Recipe action.
     *
     * @var string
     */
    protected $action = LabelValueAction::class;

    public function __construct(
        public Closure|string|null $label = null,
        public Closure|string|null $value = null,
    ) {
    }

    public static function make(?string $label = null, $value = null): self
    {
        return new self($label, $value);
    }
}

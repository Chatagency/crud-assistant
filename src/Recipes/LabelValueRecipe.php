<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Concerns\isRecipe;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;

/**
 * Label Value Action Recipe.
 */
final class LabelValueRecipe implements RecipeInterface
{
    use isRecipe;

    /**
     * @param class-string $action
     */
    protected ?string $action = LabelValueAction::class;

    public function __construct(
        public readonly \Closure|string|null $label = null,
        public readonly \Closure|string|null $value = null,
    ) {
    }

    public static function make(?string $label = null, $value = null): self
    {
        return new self($label, $value);
    }
}

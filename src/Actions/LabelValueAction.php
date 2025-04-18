<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Label Value Action.
 */
final class LabelValueAction extends Action implements ActionInterface
{
    public function __construct(
        private $model,
    ) {
    }

    public static function make($model): self
    {
        return new self($model);
    }

    public function getModel()
    {
        return $this->model;
    }

    public function prepare(): static
    {
        return parent::prepare();
    }

    public function execute(InputCollectionInterface|InputInterface|\IteratorAggregate $input)
    {
        $model = $this->model;

        $recipe = $input->getRecipe($this->getIdentifier());

        $output = $this->getOutput();

        $name = $input->getName();

        $label = $recipe->label ?? $input->getLabel();

        if (\is_callable($label)) {
            $label = $label($input, $model);
        }

        $value = $recipe->value ?? $model->{$name} ?? null;

        if (\is_callable($value)) {
            $value = $value($input, $model);
        }

        $value = $this->modifiers($value, $input, $model);

        $output->{$label} = $value;

        return $output;
    }
}

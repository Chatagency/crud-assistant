<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Traversable;
use IteratorAggregate;
use InvalidArgumentException;
use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;

/**
 * Label Value Action.
 */
final class LabelValueAction extends Action implements ActionInterface
{
    public function __construct(
        private $model
    ) {
    }

    public static function make($model): LabelValueAction
    {
        return new static($model);
    }

    public function getModel()
    {
        return $this->model;
    }

    public function prepare(): static
    {
        return parent::prepare();
    }

    public function execute(InputInterface|InputCollectionInterface|IteratorAggregate $input)
    {

        $model = $this->model;

        $recipe = $input->getRecipe(static::class);

        $output = $this->getOutput();

        $name = $input->getName();

        $label = $recipe->label ?? $input->getLabel();

        if (\is_callable($label)) {
            $label = $label($input, $model);
        }

        $value = $recipe->value ?? $model->$name ?? null;

        if (\is_callable($value)) {
            $value = $value($input, $model);
        }

        $value = $this->modifiers($value, $input, $model);

        $output->$label = $value;

        return $output;
    }
}

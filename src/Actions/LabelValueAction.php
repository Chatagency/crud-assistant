<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use InvalidArgumentException;

/**
 * Label Value Action.
 */
class LabelValueAction extends Action implements ActionInterface
{
    /**
     * Model.
     */
    protected $model;
    
    /**
     * Result is a tree instead
     * of flat.
     *
     * @var bool
     */
    protected $isTree = true;

    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input, DataContainerInterface $output)
    {
        $model = $this->model;

        if(!$model) {
            throw new InvalidArgumentException("The model is required", 500);
        }

        $recipe = $input->getRecipe(static::class);

        if ($recipe && $recipe->isIgnored()) {
            return $output;
        }

        $name = $input->getName() ?? null;

        $label = $recipe->label ?? $input->getLabel() ?? null;

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

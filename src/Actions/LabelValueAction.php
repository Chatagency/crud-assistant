<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\DataContainer;
use InvalidArgumentException;
use Traversable;

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
     * Undocumented function
     *
     * @param Traversable $model
     * 
     * @return self
     */
    public function setModel(Traversable  $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input)
    {
        $output = $this->output;
        $model = $this->model;

        if(!$model) {
            throw new InvalidArgumentException("The model is required", 500);
        }

        $recipe = $input->getRecipe(static::class);

        if ($recipe && $recipe->isIgnored()) {
            return $output;
        }

        /**
         * Internal collection
         */
        if(CrudAssistant::isInputCollection($input)) {
    
            $inputName = $input->getName();

            foreach($input as $subInput) {
                $subOutput = static::make()
                    ->setModel($model)
                    ->execute($subInput);
            }

            $output->$inputName = $subOutput;

            return;
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

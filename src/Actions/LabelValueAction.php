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
    protected $controlsRecursion = true;

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

    public function prepare()
    {
        if(!$this->model) {
            throw new InvalidArgumentException("The model is required", 500);
        }

        return parent::prepare();
    }

    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input)
    {
        /**
         * Internal collection
         */
        if(CrudAssistant::isInputCollection($input) && $this->controlsRecursion) {
    
            foreach($input as $subInput) {
                $this->execute($subInput);
            }

            return;
        }
        
        $model = $this->model;

        $recipe = $input->getRecipe(static::class);

        if ($recipe && $recipe->isIgnored()) {
            return $this->output;
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

        $this->output->$label = $value;

        return $this->output;
    }
}

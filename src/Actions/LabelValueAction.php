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
     * Ignores input.
     * Only for testing purposes
     *
     * @var bool
     */
    protected $ignore = true;

    /**
     * Internal recursion option.
     * Only for testing purposes
     *
     * @var bool
     */
    protected $recursion = true;
    
    /**
     * Sets Model
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
     * Set only for testing purposes
     *
     * @param  bool  $ignore  Only for testing purposes
     *
     * @return  self
     */ 
    public function setIgnore(bool $ignore)
    {
        $this->ignore = $ignore;

        return $this;
    }

    /**
     * Set only for testing purposes
     *
     * @param  bool  $recursion  Only for testing purposes
     *
     * @return  self
     */ 
    public function setRecursion(bool $recursion)
    {
        $this->recursion = $recursion;

        return $this;
    }
    
    /**
     * Pre Execution.
     *
     * @return self
     */
    public function prepare(): static
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
        if ($this->recursion && CrudAssistant::isInputCollection($input) && $this->controlsRecursion) {
            foreach ($input as $internalInput) {
                $this->execute($internalInput);
            }
            return true;
        }
        
        $model = $this->model;

        $recipe = $input->getRecipe(static::class);

        $output = $this->getOutput();
        
        if ($this->ignore && $recipe && $recipe->isIgnored()) {
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

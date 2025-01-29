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
class LabelValueAction extends Action implements ActionInterface
{

    protected bool $ignore = true;

    protected bool $recursion = true;

    public function __construct(
        private iterable $model
    ) 
    {}
 
    public function setIgnore(bool $ignore)
    {
        $this->ignore = $ignore;

        return $this;
    }

    public function setRecursion(bool $recursion)
    {
        $this->recursion = $recursion;

        return $this;
    }
    
    public function prepare(): static
    {
        return parent::prepare();
    }

    public function execute(InputInterface|InputCollectionInterface|IteratorAggregate $input)
    {
        if (CrudAssistant::isInputCollection($input) && $this->recursion && $this->controlsRecursion) {
            foreach ($input as $internalInput) {
                $this->execute($internalInput);
            }
        }
        
        $model = $this->model;

        $recipe = $input->getRecipe(static::class);

        $output = $this->getOutput();
        
        if ($this->ignore && $recipe && $recipe->isIgnored()) {
            return $output;
        }

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

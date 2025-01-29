<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use IteratorAggregate;
use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;

/**
 * Filter action.
 */
class FilterAction extends Action implements ActionInterface
{
    /**
     * Action control the
     * whole execution.
     *
     * @var bool
     */
    protected $controlsExecution = true;

    /**
     * Action control the
     * whole execution.
     *
     * @var bool
     */
    protected $controlsRecursion = true;

    /**
     * Data to be filtered.
     * @var array
     */
    protected $data = [];
    

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function prepare(): static
    {
        $output = $this->getOutput();
        
        $output->data = $this->data;

        return $this;
    }

    public function execute(InputInterface|InputCollectionInterface|IteratorAggregate $input)
    {
        foreach ($input as $val) {
            $this->executeOne($val);
        }
        
        return $this->output;
    }

    public function executeOne(InputInterface|InputCollectionInterface|IteratorAggregate $input)
    {
        if (CrudAssistant::isInputCollection($input) && $this->controlsRecursion) {
            foreach ($input as $val) {
                $this->executeOne($val);
            }
        }
        
        $output = $this->getOutput();
        $data = $output->data;

        $name = $input->getName();
        $recipe = $input->getRecipe(static::class);
        $value = $data[$name] ?? null;
        $ignoreIfEmpty = $recipe->ignoreIfEmpty ?? null;
        $callback = $recipe->callback ?? null;

        if ($ignoreIfEmpty && $this->isEmpty($value)) {
            unset($data[$name]);
        }
        
        if (\is_callable($callback)) {
            $data = $callback($input, $data);
        } elseif (isset($recipe->filter) && $recipe->filter) {
            unset($data[$name]);
        }

        $output->data = $data;

        return $output;
    }
}

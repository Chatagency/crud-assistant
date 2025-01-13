<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\CrudAssistant;

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

    /**
     * Pre Execution.
     *
     * @return self
     */
    public function prepare()
    {
        $output = $this->getOutput();
        
        $output->data = $this->data;

        return $this;
    }

    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input)
    {
        foreach ($input as $val) {
            $this->executeOne($val);
        }
        
        return $this->output;
    }

    /**
     * Executes single input.
     *
     * @return DataContainerInterface
     */
    public function executeOne(InputInterface $input)
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

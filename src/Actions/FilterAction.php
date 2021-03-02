<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\CrudAssistant;
use InvalidArgumentException;

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
     * Data to be filtered.
     * @var array
     */
    protected $data = [];

    /**
     * Pre Execution.
     *
     * @return DataContainerInterface
     */
    public function prepare(DataContainerInterface $output)
    {
        if(!is_array($this->data) || empty($this->data)) {
            throw new InvalidArgumentException("The data is required", 500);
        }
        
        $output->data = $this->data;

        return $output;
    }

    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input, DataContainerInterface $output)
    {
        if (CrudAssistant::isInputCollection($input)) {
            foreach ($input as $val) {
                if (CrudAssistant::isInputCollection($val)) {
                    $output = $this->execute($val, $output);
                } else {
                    $output = $this->executeOne($val, $output);
                }
            }

            return $output;
        }

        return $this->executeOne($input, $output);
    }

    /**
     * Sets $controlsExecution.
     *
     * @return self
     */
    public function setControlsExecution(bool $controlsExecution)
    {
        $this->controlsExecution = $controlsExecution;

        return $this;
    }

    /**
     * Executes single input.
     *
     * @return DataContainerInterface
     */
    protected function executeOne(InputInterface $input, DataContainerInterface $output)
    {
        $params = $this->getParams();

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
            $data = $callback($input, $params, $data);
        } elseif (isset($recipe->filter) && $recipe->filter) {
            unset($data[$name]);
        }

        $output->data = $data;

        return $output;
    }
}

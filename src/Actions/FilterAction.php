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
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input, DataContainerInterface $output)
    {
        $params = $this->getParams();

        $this->checkRequiredParams($params, ['data']);

        if (!isset($output->data)) {
            $output->data = $params->data;
        }

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
        } elseif (isset($recipe['filter']) && $recipe['filter']) {
            unset($data[$name]);
        }

        $output->data = $data;

        return $output;
    }
}

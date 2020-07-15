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
class Filter extends Action implements ActionInterface
{
    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input)
    {
        if(CrudAssistant::isInputCollection($input)) {
            foreach($input as $val) {
                if(CrudAssistant::isInputCollection($val)) {
                    $this->execute($val);
                }
                else {
                    $this->executeOne($val);
                }
            }
            return $this->output;
        }

        return $this->executeOne($input);

    }

    /**
     * Executes single input
     *
     * @param InputInterface $input
     * 
     * @return DataContainerInterface
     */
    protected function executeOne(InputInterface $input)
    {
        $params = $this->getParams();
        $output = $this->output;

        $this->checkRequiredParams($params, ['data']);

        if (!isset($output->data)) {
            $output->data = $params->data;
        }

        $data = $output->data;

        $name = $input->getName();
        $recipe = $input->getRecipe(static::class);
        $value = $data[$name] ?? null;

        if ($this->ignoreIfEmpty($value, $recipe)) {
            unset($data[$name]);
        }

        if (\is_callable($recipe)) {
            $data = $recipe($input, $params, $data);
        } elseif (isset($recipe['filter']) && $recipe['filter']) {
            unset($data[$name]);
        }

        $output->data = $data;

        return $output;
    }

}

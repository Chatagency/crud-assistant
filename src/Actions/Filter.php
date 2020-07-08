<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Filter action.
 */
class Filter extends Action implements ActionInterface
{
    /**
     * Execute action on input
     *
     * @param InputInterface $input
     * @param DataContainerInterface $output
     * 
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input, DataContainerInterface $output)
    {
        $params = $this->getParams();

        $this->checkRequiredParams($params, ['data']);

        if(!isset($output->data)) {
            $output->data = [];
        }

        $data = $params->data;

        $outputData = $output->data;
        $name = $input->getName();
        $recipe = $input->getRecipe(static::class);
        $value = $data[$name] ?? null;

        if ($this->ignoreIfEmpty($value, $recipe)) {
            return $output;
        }

        if (\is_callable($recipe)) {
            $output = $recipe($input, $params, $output);
        } elseif (!isset($recipe['filter']) || !$recipe['filter']) {
            $outputData[$name] = $data[$name];
            $output->data = $outputData;
        }

        return $output;
    }
}

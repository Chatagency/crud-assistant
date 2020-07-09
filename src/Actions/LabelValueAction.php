<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Label Value Action.
 */
class LabelValueAction extends Action implements ActionInterface
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
        $params = $params ?? $this->getParams();

        $this->checkRequiredParams($params, ['model']);

        $model = $params->model;

        $recipe = $input->getRecipe(static::class);

        if ($this->ignore($recipe)) {
            return $output;
        }

        $name = $input->getName() ?? null;
        $label = $recipe['label'] ?? $input->getLabel() ?? null;
        $value = $recipe['value'] ?? $model->$name ?? null;

        $value = $this->modifiers($value, $input, $model);

        $output->$label = $value;

        return $output;
    }
}

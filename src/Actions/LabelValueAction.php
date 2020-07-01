<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * Label Value Action.
 */
class LabelValueAction extends Action implements ActionInterface
{
    /**
     * Executes action.
     *
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null)
    {
        $params = $params ?? $this->getParams();
        
        $this->checkRequiredParams($params, ['model']);
        
        $data = [];
        $model = $params->model;

        foreach ($inputs as $input) {
            
            $recipe = $input->getRecipe(static::class);
            
            if($this->ignore($recipe)) {
                continue;
            }

            $name = $input->getName() ?? null;
            $label = $recipe['label'] ?? $input->getLabel() ?? null;
            $value = $recipe['value'] ?? $model->$name ?? null;

            $value = $this->modifiers($value, $input, $model);

            $data[$label] = $value;

        }

        return $data;
    }

}

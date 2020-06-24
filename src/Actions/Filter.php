<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * Filter action.
 */
class Filter extends Action implements ActionInterface
{
    /**
     * Executes action.
     *
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null)
    {
        $params = $params ?? $this->getParams();
        
        $this->checkRequiredParams($params, ['data']);

        $data = $params->data;

        foreach ($inputs as $input) {
            $name = $input->getName();
            $recipe = $input->getRecipe(static::class);
            $value = $data[$name] ?? null;

            if ($this->ignoreIfEmpty($value, $recipe)) {
                continue;
            }

            if ($recipe) {
                if (\is_callable($recipe)) {
                    $data = $recipe($input, $params, $data);
                } elseif (isset($recipe['filter']) && $recipe['filter']) {
                    unset($data[$name]);
                }
            }
        }

        return $data;
    }
}

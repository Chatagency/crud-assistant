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
     * Result is a tree instead
     * of flat.
     *
     * @var bool
     */
    protected $isTree = true;

    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input, DataContainerInterface $output)
    {
        $params = $this->getParams();

        $this->checkRequiredParams($params, ['model']);

        $model = $params->model;

        $recipe = $input->getRecipe(static::class);

        if ($recipe && $recipe->isIgnored()) {
            return $output;
        }

        $name = $input->getName() ?? null;

        $label = $recipe['label'] ?? $input->getLabel() ?? null;

        if (\is_callable($label)) {
            $label = $label($input, $params);
        }

        $value = $recipe['value'] ?? $model->$name ?? null;

        if (\is_callable($value)) {
            $value = $value($input, $params);
        }

        $value = $this->modifiers($value, $input, $model);

        $output->$label = $value;

        return $output;
    }
}

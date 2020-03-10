<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * Laravel migration action class.
 */
class LaravelMigration extends Action implements ActionInterface
{
    /**
     * Executes action.
     *
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null)
    {
        $this->checkRequiredParams($params, ['table', 'version']);

        $table = $params->table;
        $version = $params->version;

        foreach ($inputs as $input) {
            if ($input->getVersion() == $version) {
                $tableField = null;
                $recipe = $input->getRecipe(static::class);
                $name = $input->getName();

                if ($this->ignore($recipe)) {
                    continue;
                }

                if (isset($recipe) && \is_array($recipe)) {
                    $type = $recipe['type'] ?? null;
                    if (\is_callable($type)) {
                        $tableField = $type($table, $input);
                    } elseif ($type) {
                        $tableField = $table->$type($name);
                    } else {
                        $tableField = $table->string($name);
                    }
                } elseif (\is_callable($recipe)) {
                    $tableField = $recipe($table, $input);
                } else {
                    $tableField = $table->string($name);
                }

                $tableField = $this->modifiers($tableField, $input);
            }
        }

        return $table;
    }
}

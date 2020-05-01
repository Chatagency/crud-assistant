<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * Laravel migration action.
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
        $tableField = null;

        foreach ($inputs as $input) {
            $recipe = $input->getRecipe(static::class);
            $inputVersion = $input->getVersion();

            if ($inputVersion == $version) {

                $name = $input->getName();

                if ($this->ignore($recipe)) {
                    continue;
                }

                if (\is_callable($recipe)) {
                    $tableField = $recipe($table, $input);
                    continue;
                }

                $type = $recipe['type'] ?? null;
                
                if (\is_callable($type)) {
                    $tableField = $type($table, $input);
                } elseif ($type) {
                    $tableField = $table->$type($name);
                } else {
                    $tableField = $table->string($name);
                }

                $tableField = $this->modifiers($tableField, $input);
            }
        }

        return $table;
    }

}

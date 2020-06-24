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
        $params = $params ?? $this->getParams();
        
        $this->checkRequiredParams($params, ['table', 'version']);

        $table = $params->table;
        $version = $params->version;

        foreach ($inputs as $input) {
            $recipe = $this->getRecipe($input, $version);
            $inputVersion = \is_array($recipe) && isset($recipe['version']) ? $recipe['version'] : $input->getVersion();

            if ($inputVersion == $version) {
                $tableField = null;
                $name = $input->getName();

                if ($this->ignore($recipe)) {
                    continue;
                }

                if (\is_callable($recipe)) {
                    $tableField = $recipe($table, $input);
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
                } else {
                    $tableField = $table->string($name);
                }

                $tableField = $this->modifiers($tableField, $input);
            }
        }

        return $table;
    }

    public function getRecipe($input, $migrationVersion)
    {
        $recipe = $input->getRecipe(static::class);
        
        if(is_array($recipe) && isset($recipe['versions']) && is_array($recipe['versions'])) {
            foreach($recipe['versions'] as $version => $versionedRecipe) {
                if($migrationVersion === $version) {
                    $versionedRecipe['version'] = $version;
                    $recipe = $versionedRecipe;
                    break;
                }
            }
        }

        return $recipe;
    }
}

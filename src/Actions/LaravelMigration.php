<?php

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
        $this->checkParams($params, ['table', 'version']);

        $table = $params->table;
        $version = $params->version;

        foreach ($inputs as $input) {
            if ($input->getVersion() == $version) {
                $tableField = null;
                $migration = $input
                        ->getAction(static::class)
                    ?? null;
                $name = $input->getName();

                if (isset($migration) && is_array($migration)) {
                    $type = isset($migration['type']) ? $migration['type'] : null;
                    if (is_callable($type)) {
                        $tableField = $type($table, $input);
                    } elseif ($type) {
                        $tableField = $table->$type($name);
                    } else {
                        $tableField = $table->string($name);
                    }
                } elseif (is_callable($migration)) {
                    $tableField = $migration($table, $input);
                } else {
                    $tableField = $table->string($name);
                }

                if ($tableField && is_array($migration) && isset($migration['nullable']) && $migration['nullable']) {
                    $tableField->nullable();
                }
            }
        }

        return $table;
    }
}

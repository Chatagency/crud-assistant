<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Modifier;
use Illuminate\Database\Schema\ColumnDefinition;

/**
 * Nullable Modifier.
 */
class NullableMigrationModifier extends Modifier
{
    /**
     * Modifies value.
     *
     * @param mixed         $value
     * @param DataContainer $data
     * @param $model
     */
    public function modify($value, DataContainer $data = null, $model = null)
    {
        if ($value instanceof ColumnDefinition) {
            $value->nullable();
        }

        return $value;
    }
}

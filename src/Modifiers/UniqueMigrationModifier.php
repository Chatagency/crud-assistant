<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Modifier;
use Illuminate\Database\Schema\ColumnDefinition;

/**
 * Unique Migration Modifier.
 */
class UniqueMigrationModifier extends Modifier
{
    /**
     * Modifies value.
     *
     * @param  $value
     * @param DataContainer $data
     *
     * @return mixed
     */
    public function modify($value, DataContainer $data = null)
    {
        if ($value instanceof ColumnDefinition) {
            $value->unique();
        }

        return $value;
    }
}

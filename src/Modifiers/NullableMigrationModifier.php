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
     * @param  $value
     * @param DataContainer $data
     *
     * @return mixed
     */
    public function modify($value, DataContainer $data = null)
    {
        if ($value instanceof ColumnDefinition) {
            $value->nullable();
        }

        return $value;
    }
}

<?php

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\Modifier;
use Chatagency\CrudAssistant\DataContainer;
use Illuminate\Database\Schema\ColumnDefinition;

/**
 * Nullable Modifier
 */
class NullableMigrationModifier extends Modifier
{
    public function modify($value, DataContainer $data = null)
    {
        if($value instanceof ColumnDefinition) {
            $value->nullable();
        }
        
        return $value;
    }
}

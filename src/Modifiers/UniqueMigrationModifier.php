<?php

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\Modifier;
use Chatagency\CrudAssistant\DataContainer;
use Illuminate\Database\Schema\ColumnDefinition;

/**
 * Unique Migration Modifier
 */
class UniqueMigrationModifier extends Modifier
{
    public function modify($value, DataContainer $data = null)
    {
        if($value instanceof ColumnDefinition) {
            $value->unique();
        }
        
        return $value;
    }
}

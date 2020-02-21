<?php

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\Modifier;
use Chatagency\CrudAssistant\DataContainer;
use Illuminate\Database\Schema\ColumnDefinition;

/**
 * Unsigned Migration Modifier
 */
class UnsignedMigrationModifier extends Modifier
{
    public function modify($value, DataContainer $data = null)
    {
        if($value instanceof ColumnDefinition) {
            $value->unsigned();
        }
        
        return $value;
    }
}

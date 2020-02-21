<?php

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\Modifier;
use Chatagency\CrudAssistant\DataContainer;
use Illuminate\Database\Schema\Blueprint;

/**
 * Nullable Modifier
 */
class NullableMigrationModifier extends Modifier
{
    public function modify($value, DataContainer $data = null)
    {
        if($value instanceof Blueprint) {
            $value->nullable();
        }
        
        return $value;
    }
}

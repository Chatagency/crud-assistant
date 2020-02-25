<?php

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\Modifier;
use Chatagency\CrudAssistant\DataContainer;

/**
 * Sanitized Modifier
 */
class SanitizedModifier extends Modifier
{
    public function modify($value, DataContainer $data = null)
    {
        $filter = $data->filter ?? ENT_QUOTES;
        return html_entity_decode($value, $filter);
    }
}

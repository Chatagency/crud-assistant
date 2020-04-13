<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Modifier;

/**
 * Sanitized Modifier.
 */
class SanitizedModifier extends Modifier
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
        $filter = $data->filter ?? ENT_QUOTES;

        return html_entity_decode($value, $filter);
    }
}

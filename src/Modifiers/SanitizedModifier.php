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
     * @param mixed      $value
     * @param mixed|null $model
     */
    public function modify($value, $model = null)
    {
        $data = $this->getData();
        
        $filter = $data->filter ?? ENT_QUOTES;

        return html_entity_decode($value, $filter);
    }
}

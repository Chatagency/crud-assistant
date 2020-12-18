<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Modifier;

/**
 * Hide Password Modifier.
 */
class HidePasswordModifier extends Modifier
{
    protected $defaultValue = '******';

    /**
     * Modifies value.
     *
     * @param mixed $value
     */
    public function modify($value, DataContainer $data = null, $model = null)
    {
        return $data && isset($data->value) ? $data->value : $this->defaultValue;
    }

    /**
     * Returns default value.
     *
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
}

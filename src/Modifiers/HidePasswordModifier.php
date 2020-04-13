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
     * @param mixed         $value
     * @param DataContainer $data
     * @param $model
     */
    public function modify($value, DataContainer $data = null, $model = null)
    {
        $content = $data && isset($data->value) ? $data->value : $this->defaultValue;

        return $content;
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

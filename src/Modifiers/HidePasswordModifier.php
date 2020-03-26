<?php

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\Modifier;
use Chatagency\CrudAssistant\DataContainer;

/**
 * Hide Password Modifier
 */
class HidePasswordModifier extends Modifier
{
    
    protected $defaultValue = '******';
  
    /**
     * Obscures Password
     *
     * @param $value
     * @param DataContainer $data
     * 
     * @return mixed
     */
    public function modify($value, DataContainer $data = null)
    {
        $content = $data && isset($data->value) ? $data->value : $this->defaultValue;
        
        return $content;
    }
    
    /**
     * Returns default value
     *
     * @return string
     */
    public function getDefaultValue()
    {
      return $this->defaultValue;
    }
}

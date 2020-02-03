<?php

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\Modifier;
use Chatagency\CrudAssistant\DataContainer;
use InvalidArgumentException;

/**
 * Is Link Modifier
 */
class IsLink extends Modifier
{
    protected $view = 'vendor.crud-assistant-extras.link';
    
    
    public function modify($value, DataContainer $data = null)
    {
        $action = $value;
        $view = $data->view ?? $this->view;
        $label = $data->label ?? 'Link';
        $type = $data->type ?? 'primary';
        $target = $data->target ?? null;
        $class = $data->class ?? null;
        
        if(!$action){
            throw new InvalidArgumentException('The argument value cannot be empty, null or false', 500);
        }
        
        return view($view)
            ->with('action', $action)
            ->with('label', $label)
            ->with('type', $type)
            ->with('target', $target)
            ->with('class', $class)
            ->render();
    }
}

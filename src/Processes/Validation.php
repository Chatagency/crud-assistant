<?php

namespace Chatagency\CrudAssistant\Processes;

use Chatagency\CrudAssistant\Contracts\ProcessInterface;

/**
 * Crud Class
 */
class Validation implements ProcessInterface
{
    protected $rule;
    
    public function __construct(array $rule)
    {
        $this->rule = $rule;
    }
    
    public function process()
    {
        
    }
}

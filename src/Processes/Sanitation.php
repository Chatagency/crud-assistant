<?php

namespace Chatagency\CrudAssistant\Processes;

use Chatagency\CrudAssistant\Contracts\ProcessInterface;

/**
 * Crud Class
 */
class Sanitation implements ProcessInterface
{
    protected $rule;
    
    public function __construct(string $rule)
    {
        $this->rule = $rule;
    }
    
    public function process()
    {
        
    }
    
}

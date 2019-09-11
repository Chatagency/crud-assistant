<?php

namespace Chatagency\CrudAssistant\Contracts;
use Chatagency\CrudAssistant\Input;

/**
 * Input Collection Interface
 */
interface InputCollectionInterface
{
    /**
     * Constructor
     * @param array $inputsArray
     * @return self
     */
    public function __construct(array $inputsArray = []);
    
    /**
     * Adds input to the array
     * @param Input $input
     * @param string $key
     * @return self
     */
    public function add(Input $input, string $key = null);
    
    /**
     * Removes input from the array if exists
     * @param  string $key [description]
     * @return self
     */
    public function remove(string $key);
    
    /**
     * Retruns inputs array count
     * @return int
     */
    public function count();
    
    /**
     * Returns inputs array
     * @return array
     */
    public function getInputs();
    
    /**
     * Processes all inputs
     * @return [type] [description]
     */
    public function process();
    
}

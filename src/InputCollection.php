<?php

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Exception;

/**
 * Input Collection Class
 */
class InputCollection implements InputCollectionInterface
{
    /**
     * Inputs array
     * @var array
     */
    protected $inputsArray = [];
    
    /**
     * Constructor
     * @param array $inputsArray
     * @return self
     */
    public function __construct(array $inputsArray = [])
    {
        $this->inputsArray = array_merge($this->inputsArray, $inputsArray);
        
        return $this;
    }
    
    /**
     * Adds input to the array
     * @param InputInterface $input
     * @param string $key
     * @return self
     */
    public function add(InputInterface $input, string $key = null)
    {
        $key = $key ?? $input->getName();
        
        $this->inputsArray[$key] = $input;
        
        return $this;
    }
    /**
     * Removes input from the array if exists
     * @param  string $key [description]
     * @return self
     */
    public function remove(string $key)
    {
        if(isset($this->inputsArray[$key])) {
            unset($this->inputsArray[$key]);
        }
        return $this;
    }
    
    /**
     * Retruns inputs array count
     * @return int
     */
    public function count()
    {
        return count($this->inputsArray);
    }
    
    /**
     * Returns inputs array
     * @param string $key
     * @return InputInterface
     */
    public function getInput(string $key)
    {
        if(isset($this->inputsArray[$key])){
            return $this->inputsArray[$key];
        }
        
        throw new InvalidArgumentException("The ".$key." Input has not been registered or does not exist", 500);
    }
    
    /**
     * Returns inputs array
     * @return array
     */
    public function getInputs()
    {
        return $this->inputsArray;
    }
    
    /**
     * Processes all inputs
     * @return array
     * @throws Exception
     */
    public function process()
    {
        
    }
    
}

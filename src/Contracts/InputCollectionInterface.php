<?php

namespace Chatagency\CrudAssistant\Contracts;

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
    public function __construct(array $inputsArray = [], ActionFactory $actionFactory = null);
    
    /**
     * Adds input to the array
     * @param InputInterface $input
     * @param string $key
     * @return self
     */
    public function add(InputInterface $input, string $key = null);
    
    /**
     * Removes input from the array if exists
     * @param string $key [description]
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
     * @param string $key
     * @return InputInterface
     * @throws InvalidArgumentException
     */
    public function getInput(string $key);
    
    /**
     * Returns inputs array
     * @return array
     */
    public function getInputs();
    
    /**
     * Returns Input Names
     * @return array
     */
    public function getInputNames();
    
    /**
     * Execute actions
     * @param string $type
     * @param $params
     */
    public function execute(string $type, $params = null);
    
}

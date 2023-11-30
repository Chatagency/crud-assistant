<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Action Interface.
 */
interface ActionInterface
{
    /**
     * Initialize output
     *
     * @return static
     */
    public function initOutput();
    
    /**
     * Returns recipe identifier
     *
     * @return string
     */
    public static function getIdentifier();
    
    /**
     * Sets generic set genericData.
     *
     * @param DataContainerInterface $genericData
     * 
     * @return ActionInterface
     */
    public function setGenericData(DataContainerInterface $genericData);
    
    /**
     * Set processed
     *
     * @param bool $processInternalCollection processed
     *
     * @return self
     */ 
    public function setProcessInternalCollection(bool $processInternalCollection);

    /**
     * Returns generic set genericData.
     *
     * @return self
     */
    public function getGenericData();
    
    /**
     * Pre Execution.
     *
     * @return self
     */
    public function prepare();

    /**
     * Execute action on input.
     * 
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input);

    /**
     * Post Execution.
     *
     * @return self
     */
    public function cleanup();

    /**
     * Notifies the collection the output
     * result must be in a tree format.
     *
     * @return bool
     */
    public function controlsRecursion();

    /**
     * Notifies the collection the action
     * will take control of the whole
     * execution. This triggers the
     * method executeAll().
     *
     * @return bool
     */
    public function controlsExecution();
    
    /**
     * Process an internal input collection
     * the same way a regular input is
     * processed
     *
     * @return  boolean
     */ 
    public function processInternalCollection();

    /**
     * Returns output
     *
     * @return DataContainerInterface
     */
    public function getOutput();
}

<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Action Interface.
 */
interface ActionInterface
{
    /**
     * Construct
     *
     * @param DataContainerInterface $output
     * 
     * @return self
     */
    public function __construct(DataContainerInterface $output = null);

    /**
     * Sets generic set genericData.
     *
     * @param DataContainerInterface $genericData
     * 
     * @return ActionInterface
     */
    public function setGenericData(DataContainerInterface $genericData);

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
     * Returns output
     *
     * @return DataContainerInterface
     */
    public function getOutput();
}

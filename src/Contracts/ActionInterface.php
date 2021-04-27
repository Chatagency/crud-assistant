<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Action Interface.
 */
interface ActionInterface
{
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
     * @return DataContainerInterface
     */
    public function getGenericData();
    
    /**
     * Pre Execution.
     *
     * @return DataContainerInterface
     */
    public function prepare(DataContainerInterface $output);

    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input, DataContainerInterface $output);

    /**
     * Post Execution.
     *
     * @return DataContainerInterface
     */
    public function cleanup(DataContainerInterface $output);

    /**
     * Notifies the collection the output
     * result must be in a tree format.
     *
     * @return bool
     */
    public function isTree();

    /**
     * Notifies the collection the action
     * will take control of the whole
     * execution. This triggers the
     * method executeAll().
     *
     * @return bool
     */
    public function controlsExecution();
}

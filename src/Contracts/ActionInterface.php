<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Action Interface.
 */
interface ActionInterface
{
    /**
     * Execute action on input.
     *
     * @param InputInterface $input
     * @param DataContainerInterface $output
     * 
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input, DataContainerInterface $output);
}

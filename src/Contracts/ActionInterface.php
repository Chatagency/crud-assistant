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
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input, DataContainerInterface $output);
}

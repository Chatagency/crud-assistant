<?php

namespace Chatagency\CrudAssistant\Tests\TestClasses;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

class TestAction extends Action implements ActionInterface
{
    /**
     * Executes action.
     *
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null)
    {
        return 'TestAction';
    }
}

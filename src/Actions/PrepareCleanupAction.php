<?php

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

class PrepareCleanupAction extends Action implements ActionInterface
{
    /**
     * Pre Execution.
     *
     * @return self
     */
    public function prepare()
    {
        $output = $this->getOutput();
        
        $output->prepare = 1;

        return parent::prepare();
    }

    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input)
    {
        $output = $this->getOutput();
        
        $output->{$input->getName()} = $input->getLabel();
        
        return $output;
    }

    /**
     * Post Execution.
     *
     * @return self
     */
    public function cleanup()
    {
        $output = $this->getOutput();
        
        $output->cleanup = 1;

        return parent::cleanup();
    }

}

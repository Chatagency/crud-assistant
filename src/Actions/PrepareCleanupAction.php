<?php

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;

class PrepareCleanupAction extends Action implements ActionInterface
{
    /**
     * Pre Execution.
     *
     * @return self
     */
    public function prepare()
    {
        $this->output->prepare = 1;

        return parent::prepare();
    }

    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input)
    {
        $this->output->{$input->getName()} = $input->getLabel();
        
        return $this->output;
    }

    /**
     * Post Execution.
     *
     * @return self
     */
    public function cleanup()
    {
        $this->output->cleanup = 1;

        return parent::cleanup();
    }

}

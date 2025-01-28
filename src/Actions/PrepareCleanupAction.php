<?php

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;

class PrepareCleanupAction extends Action implements ActionInterface
{

    public function prepare(): static
    {
        $output = $this->getOutput();
        
        $output->set('prepare', 1);

        return parent::prepare();
    }

    public function execute(InputInterface $input)
    {
        $output = $this->getOutput();
        
        $output->{$input->getName()} = $input->getLabel();
        
        return $output;
    }

    public function cleanup(): static
    {
        $output = $this->getOutput();
        
        $output->set('cleanup', 1);

        return parent::cleanup();
    }

}

<?php

namespace Chatagency\CrudAssistant\Actions;

use IteratorAggregate;
use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;

class PrepareCleanupAction extends Action implements ActionInterface
{

    public function prepare(): static
    {
        $output = $this->getOutput();
        
        $output->set('prepare', 1);

        return parent::prepare();
    }

    public function execute(InputInterface|InputCollectionInterface|IteratorAggregate  $input)
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

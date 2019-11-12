<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;

class InputCollectionTest extends TestCase
{
    
    /** @test */
    public function an_input_collection_can_be_created_and_inputs_can_be_added()
    {
        
        $form = new InputCollection();
        $form->add(new TextInput("name", "Name", 1));
        $this->assertCount(1, $form->getInputs());
        $form->add(new TextInput("lastname", "Last Name", 1));
        $this->assertCount(2, $form->getInputs());
        
    }
    
}

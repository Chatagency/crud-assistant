<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\Inputs\TextInput;

class InputTest extends TestCase
{
    
    /** @test */
    public function an_input_can_be_created_with_just_a_name()
    {
        $input = new TextInput('email');
        
        $this->assertEquals('email', $input->getName());
        $this->assertEquals('email', $input->getLabel());
        $this->assertEquals('email', $input->getId());
        $this->assertEquals(1, $input->getVersion());
        
    }
    
    /** @test */
    public function an_input_can_be_created_with_name_label_and_version()
    {
        $input = new TextInput('email', 'Email', 1);
        
        $this->assertEquals('email', $input->getName());
        $this->assertEquals('Email', $input->getLabel());
        $this->assertEquals('email', $input->getId());
        $this->assertEquals(1, $input->getVersion());
    }
    
}

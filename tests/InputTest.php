<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\DataContainer;

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
        $input = new TextInput('email', 'Email', 2);
        
        $this->assertEquals('email', $input->getName());
        $this->assertEquals('Email', $input->getLabel());
        $this->assertEquals('email', $input->getId());
        $this->assertEquals(2, $input->getVersion());
    }
    
    /** @test */
    public function an_action_can_can_be_added_to_an_input()
    {
        $validationValue = [
            'required',
            'email'
        ];
        
        $input = new TextInput('email', 'Email', 1);
        $input->setAction(new DataContainer('validation', $validationValue));
        
        $this->assertEquals($input->getAction('validation')->value, $validationValue);
        
    }
    
}

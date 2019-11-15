<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\Inputs\GenericInput;
use Chatagency\CrudAssistant\DataContainer;

class InputTest extends TestCase
{
    
    /** @test */
    public function an_input_can_be_created_with_just_a_name()
    {
        $input = new GenericInput('email');
        $input->setType('text');
        
        $this->assertEquals('email', $input->getName());
        $this->assertEquals('email', $input->getLabel());
        $this->assertEquals(1, $input->getVersion());
        
    }
    
    /** @test */
    public function an_input_can_be_created_with_name_label_and_version()
    {
        $input = new GenericInput('email', 'Add your email', 2);
        
        $this->assertEquals('email', $input->getName());
        $this->assertEquals('Add your email', $input->getLabel());
        $this->assertEquals(2, $input->getVersion());
    }
    
    /** @test */
    public function an_action_can_can_be_added_to_an_input()
    {
        $validationValue = [
            'required',
            'email'
        ];
        
        $input = new GenericInput('email', 'Email', 1);
        $input->setAction(new DataContainer('validation', $validationValue));
        
        $this->assertEquals($input->getAction('validation')->value, $validationValue);
        
    }
    
    /** @test */
    public function the_label_and_version_can_be_set()
    {
        $input = new GenericInput('email');
        $input->setLabel('Add your email');
        $input->setVersion(2);
        
        $this->assertEquals('Add your email', $input->getLabel());
        $this->assertEquals(2, $input->getVersion());
        
    }
    
    /** @test */
    public function an_arbitrary_attribute_can_be_set()
    {
        $input = new GenericInput('email');
        
        $this->assertNull($input->getAttribute('id'));
        
        $input->setAttribute('id', 'FormEmail');
        
        $this->assertEquals('FormEmail', $input->getAttribute('id'));
        $this->assertCount(1, $input->getAttributes());
    }
    
}

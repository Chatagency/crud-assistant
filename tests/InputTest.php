<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\DataContainer;

class InputTest extends TestCase
{
    
    /** @test */
    public function an_input_can_be_created_with_just_a_name()
    {
        $input = new TextInput('email');
        $input->setType('email');
        
        $this->assertEquals('email', $input->getName());
        $this->assertEquals('email', $input->getLabel());
        $this->assertEquals(1, $input->getVersion());
        
    }
    
    /** @test */
    public function an_input_can_be_created_with_name_label_and_version()
    {
        $input = new TextInput('email', 'Add your email', 2);
        $input->setType('email');
        
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
        
        $input = new TextInput('email', 'Email', 1);
        $input->setType('email');
        $input->setAction(new DataContainer(LaravelValidation::class, $validationValue));
        
        $this->assertEquals($input->getAction(LaravelValidation::class)->value, $validationValue);
        
    }
    
    /** @test */
    public function the_label_and_version_can_be_set_after_the_input_has_been_instantiated()
    {
        $input = new TextInput('email');
        $input->setType('email');
        $input->setLabel('Add your email');
        $input->setVersion(2);
        
        $this->assertEquals('Add your email', $input->getLabel());
        $this->assertEquals(2, $input->getVersion());
        
    }
    
    /** @test */
    public function an_arbitrary_attribute_can_be_added_to_an_input_class()
    {
        $input = new TextInput('email');
        $input->setType('email');
        
        $this->assertNull($input->getAttribute('id'));
        
        $input->setAttribute('id', 'FormEmail');
        
        $this->assertEquals('FormEmail', $input->getAttribute('id'));
        $this->assertCount(1, $input->getAttributes());
    }
    
    /** @test */
    public function sub_elements_can_be_added_to_an_input_class()
    {
        $input = new SelectInput('hobbies', "Your Hobbies");
        $hobbies = ['run', 'play pokemon go', 'drink wine'];
        $input->setSubElements($hobbies);
        
        $this->assertCount(3, $input->getSubElements());
        
    }
    
}

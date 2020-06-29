<?php

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\Actions\LaravelValidationRules;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\Inputs\OptionInput;
use Chatagency\CrudAssistant\Inputs\TextInput;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    /** @test */
    public function an_input_can_be_created_with_just_a_name()
    {
        $input = new TextInput('name');

        $this->assertEquals('name', $input->getName());
        $this->assertEquals('name', $input->getLabel());
        $this->assertEquals(1, $input->getVersion());
    }

    /** @test */
    public function an_input_can_be_created_with_name_label_version_and_type()
    {
        $input = new TextInput('email', 'Add your email', 2);
        $input->setType('email');

        $this->assertEquals('email', $input->getName());
        $this->assertEquals('Add your email', $input->getLabel());
        $this->assertEquals(2, $input->getVersion());
        $this->assertEquals('email', $input->getType());
    }

    /** @test */
    public function an_action_recipe_can_can_be_added_to_an_input()
    {
        $validationValue = [
            'required',
            'email',
        ];

        $input = new TextInput('email', 'Email', 1);
        $input->setType('email');
        $input->setRecipe(LaravelValidationRules::class, $validationValue);

        $this->assertEquals($input->getAction(LaravelValidationRules::class), $validationValue);
    }

    /** @test */
    public function if_a_recipe_with_invalid_action_is_set_an_exception_is_throw()
    {
        $this->expectException(InvalidArgumentException::class);

        $input = new TextInput('email', 'Email', 1);
        $input->setType('email');
        
        $input->setRecipe(CrudAssistant::class, 1);

        $this->assertNull($input->getRecipe(CrudAssistant::class));

    }
    
    /** @test */
    public function if_recipe_does_not_exist_in_class_null_is_returned()
    {
        $validationValue = [
            'required',
            'email',
        ];

        $input = new TextInput('email', 'Email', 1);
        $input->setType('email');

        $this->assertNull($input->getAction(LaravelValidationRules::class));
    }
    
    /** @test */
    public function the_name_label_and_version_can_be_set_after_the_input_has_been_instantiated()
    {
        $input = new TextInput('email');

        $input->setName('new_email');
        $input->setType('email');
        $input->setLabel('Add your email');
        $input->setVersion(2);

        $this->assertEquals('new_email', $input->getName());
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
    public function an_arbitrary_attribute_can_be_removed_from_an_input_class()
    {
        $input = new TextInput('email');
        $input->setType('email');

        $this->assertNull($input->getAttribute('id'));

        $input->setAttribute('id', 'FormEmail');

        $this->assertEquals('FormEmail', $input->getAttribute('id'));
        $this->assertCount(1, $input->getAttributes());
        
        $input->unsetAttribute('id');
        
        $this->assertCount(0, $input->getAttributes());
    }

    /** @test */
    public function sub_elements_can_be_added_to_an_input_class()
    {
        $input = new SelectInput('hobbies', 'Your Hobbies');
        $hobbies = new InputCollection([
            new OptionInput('watch tv'), 
            new OptionInput('play pokemon go'), 
            new OptionInput('drink wine'),
        ]);
        $input->setSubElements($hobbies);

        $this->assertCount(3, $input->getSubElements());
        
    }

    /** @test */
    public function sub_elements_are_themselves_inputs()
    {
        $input = new SelectInput('hobbies', 'Your Hobbies');
        $hobbies = [
            new OptionInput('watch tv'),
        ];
        $input->setSubElements($hobbies);

        $this->assertInstanceOf(Input::class, $input->getSubElements()[0]);

        
    }
}

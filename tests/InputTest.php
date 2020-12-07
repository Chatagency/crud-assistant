<?php

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\Inputs\OptionInput;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Recipes\LabelValueActionRecipe;
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
    public function an_action_recipe_can_can_be_added_to_an_input()
    {
        $value  = [
            'label' => 'This is an email',
        ];

        $input = new TextInput('email', 'Email');
        $input->setType('email');
        $input->setRecipe(new LabelValueActionRecipe($value));

        $this->assertEquals($input->getRecipe(LabelValueAction::class)->all(), $value);

    }

    /** @test */
    public function if_recipe_does_not_exist_in_class_null_is_returned()
    {
        $input = new TextInput('email', 'Email');
        $input->setType('email');

        $this->assertNull($input->getRecipe(LabelValueAction::class));
    }
    
    /** @test */
    public function the_name_label_version_and_type_can_be_set_after_the_input_has_been_instantiated()
    {
        $input = new TextInput('email');

        $input->setName('new_email');
        $input->setType('email');
        $input->setLabel('Add your email');
        $input->setVersion(2);

        $this->assertEquals('new_email', $input->getName());
        $this->assertEquals('Add your email', $input->getLabel());
        $this->assertEquals('email', $input->getType());
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
        $hobbies = new InputCollection();
        $hobbies->setInputs([
            new OptionInput('watch_tv'), 
            new OptionInput('play_pokemon go'), 
            new OptionInput('drink_wine'),
        ]);

        $input->setSubElements($hobbies);

        $this->assertCount(3, $input->getSubElements());
        
    }

    /** @test */
    public function sub_elements_are_an_input_collection_with_inputs()
    {
        $input = new SelectInput('hobbies', 'Your Hobbies');
        $hobbies = new InputCollection();
        $hobbies->setInputs([
            new OptionInput('watch_tv'),
        ]);
        $input->setSubElements($hobbies);

        $subElements = $input->getSubElements();

        $this->assertInstanceOf(InputCollectionInterface::class, $subElements);
        $this->assertInstanceOf(InputInterface::class, $subElements->getInput('watch_tv'));

        
    }

    
}

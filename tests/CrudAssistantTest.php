<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\Actions\SanitationAction;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;
use BadMethodCallException;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Recipes\SanitationRecipe;

class CrudAssistantTest extends TestCase
{

    /** @test */
    public function when_the_make_method_is_called_on_crud_assistant_an_input_collection_instance_is_returned()
    {
        $manager = CrudAssistant::make([]);

        $this->assertInstanceOf(InputCollectionInterface::class, $manager);
    }

    /** @test */
    public function an_array_of_inputs_instances_can_be_passed_to_the_constructor()
    {
        $inputs = [
            new TextInput('name'),
            new TextInput('email'),
        ];

        $manager = new CrudAssistant($inputs);

        $this->assertEquals(2, $manager->getCollection()->count());
    }

    /** @test */
    public function the_is_input_collection_helper_checks_if__parameter_is_an_input_collection()
    {
        $this->assertTrue(CrudAssistant::isInputCollection(new InputCollection()));
        
        $this->assertFalse(CrudAssistant::isInputCollection(new TextInput()));
    }

    /** @test */
    public function the_is_closure_helper_checks_if_parameter_is_a_closure()
    {
        $this->assertTrue(CrudAssistant::isClosure(function(){}));
        
        $this->assertFalse(CrudAssistant::isClosure('array_map'));
    }
}

<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\Actions\SanitationAction;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;
use BadMethodCallException;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
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
    public function actions_can_be_executed_using_the_execute_method_from_the_input_collection()
    {
        $name = new TextInput('name');
        $name->setRecipe(new SanitationRecipe([
            'type' => FILTER_SANITIZE_SPECIAL_CHARS
        ]));

        $manager = new CrudAssistant([$name]);
        
        $action = SanitationAction::make()->setRequestArray([
            'name' => 'John Smith',
        ]);
        
        $output = $manager->execute($action);

        $sanitation = $output->requestArray;

        $this->assertEquals('John Smith', $sanitation['name']);
        $this->assertCount(2, $sanitation);
    }

    /** @test */
    public function a_method_from_the_input_collection_can_also_be_called_directly_on_the_manager()
    {
        $manager = new CrudAssistant([
            new TextInput('name'),
        ]);

        $this->assertCount(1, $manager->getInputs());
        $this->assertEquals(1, $manager->count());
    }

    /** @test */
    public function if_an_action_or_method_does_not_exists_an_exception_is_thrown()
    {
        $manager = new CrudAssistant([
            new TextInput('name'),
        ]);

        $this->expectException(BadMethodCallException::class);
        $manager->randomMethod();
    }
}

<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\Actions\Sanitation;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Tests\TestClasses\TestAction;
use BadMethodCallException;
use Chatagency\CrudAssistant\DataContainer;

class CrudAssistantTest extends TestCase
{

    /** @test */
    public function a_crud_assistant_instance_can_be_created_statically()
    {
        $manager = CrudAssistant::make([]);

        $this->assertInstanceOf(CrudAssistant::class, $manager);
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
    public function actions_can_be_executed_using_the_action_class_base_name()
    {
        $name = new TextInput('name');
        $name->setRecipe(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
        $name->setRecipe(TestAction::class, null);

        $manager = new CrudAssistant([$name]);

        $manager->execute(new TestAction());

        $sanitation = $manager->execute(new Sanitation(
            new DataContainer([
                'requestArray' => [
                    'name' => 'John Smith',
                ],
            ])
        ));

        $this->assertEquals('John Smith', $sanitation['name']);
        $this->assertCount(2, $sanitation);
        $this->assertEquals('TestAction', $manager->execute(new TestAction()));
    }

    /** @test */
    public function a_method_from_the_collection_can_also_be_called_directly_on_the_manager()
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

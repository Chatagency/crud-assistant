<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\Actions\Sanitation;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Tests\TestClasses\TestAction;
use BadMethodCallException;

class CrudAssistantTest extends TestCase
{
    /**
     * Returns instance of ActionFactory
     * @return ActionFactory
     */
    public function getActionFactory()
    {
        /**
         * Laravel config() is not available
         * inside the package.
         *
         * @var array
         */
        $config = require __DIR__.'/../config/config.php';

        return new ActionFactory($config['actions']);
    }
    
    /** @test */
    public function a_crud_assistant_instance_can_be_created_statically()
    {
        $manager = CrudAssistant::make([], $this->getActionFactory());

        $this->assertInstanceOf(CrudAssistant::class, $manager);
    }

    /** @test */
    public function an_array_of_inputs_instances_can_be_passed_to_the_constructor()
    {
        $inputs = [
            new TextInput('name'),
            new TextInput('email'),
        ];

        $manager = new CrudAssistant($inputs, $this->getActionFactory());

        $this->assertEquals(2, $manager->getCollection()->count());
    }

    /** @test */
    public function actions_can_be_excecuted_using_the_action_class_base_name()
    {
        $name = new TextInput('name');
        $name->setRecipe(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
        $name->setRecipe(TestAction::class, null);

        $actionFactory = $this->getActionFactory();
        $actionFactory->registerAction(TestAction::class);
        $manager = new CrudAssistant([$name], $actionFactory);

        $test = $manager->TestAction([]);

        $sanitation = $manager->sanitation([
            'requestArray' => [
                'name' => 'John Smith',
            ],
        ]);

        $this->assertEquals('John Smith', $sanitation['name']);
        $this->assertCount(2, $sanitation);
        $this->assertEquals('TestAction', $manager->TestAction([]));
    }

    /** @test */
    public function a_method_from_the_collection_can_also_be_called_directly_on_the_manager()
    {
        $manager = new CrudAssistant([
            new TextInput('name'),
        ], $this->getActionFactory());

        $this->assertCount(1, $manager->getInputs());
        $this->assertEquals(1, $manager->count());
    }

    /** @test */
    public function if_an_action_or_method_does_not_exists_an_exception_is_thrown()
    {
        $manager = new CrudAssistant([
            new TextInput('name'),
        ], $this->getActionFactory());

        $this->expectException(BadMethodCallException::class);
        $manager->randomMetod();
    }
}

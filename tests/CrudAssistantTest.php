<?php

namespace Chatagency\CrudAssistant\Tests;

use Orchestra\Testbench\TestCase;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Actions\Sanitation;
use Chatagency\CrudAssistant\Actions\LaravelValidationLabels;
use PHPUnit\Framework\Error\Notice;
use BadMethodCallException;

class CrudAssistantTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        $config = require __DIR__.'/../config/config.php';
        $this->app->config->set('crud-assistant.actions', $config['actions']);
    }
    
    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = $this->resolveApplication();
        /**
         * Just the config resolver is needed
         */
        $this->resolveApplicationConfiguration($app);
        return $app;
    }
    
    /** @test */
    public function a_crud_assistant_instance_can_be_created_statically()
    {
        $manager = CrudAssistant::make();
        
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
    public function actions_can_be_excecuted_using_the_action_class_base_name()
    {
        $name = new TextInput('name');
        $name->setAction(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
        
        $manager = new CrudAssistant([$name]);
        $sanitation = $manager->sanitation([
            'requestArray' => [
                'name' => "John Smith"
            ]
        ]);
        
        $this->assertEquals("John Smith", $sanitation['name']);
        $this->assertCount(2, $sanitation);
    }
    
    /** @test */
    public function a_method_from_the_collection_can_also_be_called_directly_on_the_manager()
    {
        $manager = new CrudAssistant([
            new TextInput('name')
        ]);
        
        $this->assertCount(1, $manager->getInputs());
        $this->assertEquals(1, $manager->count());
    }
    
    /** @test */
    public function if_an_action_or_method_does_not_exists_an_exception_is_thrown()
    {
        $manager = new CrudAssistant([
            new TextInput('name')
        ]);
        
        $this->expectException(BadMethodCallException::class);
        $manager->randomMetod();
        
    }
    
}

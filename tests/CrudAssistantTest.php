<?php

namespace Chatagency\CrudAssistant\Tests;

use Orchestra\Testbench\TestCase;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use PHPUnit\Framework\Error\Notice;

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
    public function a_collection_can_be_created_using_the_crud_assistant_manager()
    {
        $manager = new CrudAssistant();
        $manager->createCollection('contactForm');
        
        $this->assertInstanceOf(InputCollectionInterface::class, $manager->contactForm);
        
    }
    
    /** @test */
    public function the_collection_can_be_accessed_directly_using_the_name_assigned_to_it()
    {
        $manager = new CrudAssistant();
        $manager->createCollection('contactForm');
        $manager->contactForm->add(new TextInput('email'));
        
        $this->assertInstanceOf(InputInterface::class, $manager->contactForm->getInput('email'));
        
    }
    
    /** @test */
    public function if_a_non_existing_collection_is_accessed_a_php_notice_is_triggered()
    {
        $manager = new CrudAssistant();
        
        $this->expectException(Notice::class);
        $manager->contactForm;
    }
    
    /** @test */
    public function an_crud_assistant_instance_can_be_created_statically()
    {
        $manager = CrudAssistant::make();
        
        $this->assertInstanceOf(CrudAssistant::class, $manager);
    }
    
}

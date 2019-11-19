<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Actions\LaravelMigration;
use Chatagency\CrudAssistant\InputCollection;
use Illuminate\Database\Schema\Blueprint;

class LaravelMigrationTest extends TestCase
{
    /** @test */
    public function migrations_can_be_created_from_inputs()
    {
        
        $migration = new LaravelMigration();
        
        $name = new TextInput('name', 'Name');
        $name->setAction(new DataContainer(LaravelMigration::class, [
            'type' => 'text'
        ]));
        
        $email = new TextInput('email', 'Email');
        $email->setAction(new DataContainer(LaravelMigration::class, [
            'nullable' => true
        ]));
        
        $description = new TextInput('description', 'Description');
        $description->setAction(new DataContainer(LaravelMigration::class, [
            'type' => 'longText'
        ]));
        
        $inputs = [$name, $email, $description];
        
        $container = new DataContainer();
        $container->version = 1;
        
        $blueprint = new Blueprint('contacts', function(Blueprint $table) use ($inputs, $migration, $container) {
            $container->table = $table;
            $migration->execute($inputs, $container);
        });
        
        $this->assertCount(3, $blueprint->getColumns());
        
    }
    
    /** @test */
    public function migrations_can_be_created_from_a_collection()
    {
        $migration = new LaravelMigration();
        
        $name = new TextInput('name', 'Name');
        $name->setAction(new DataContainer(LaravelMigration::class, [
            'type' => 'text'
        ]));
        
        $email = new TextInput('email', 'Email');
        $email->setAction(new DataContainer(LaravelMigration::class, [
            'nullable' => true
        ]));
        
        $inputs = [$name, $email];
        
        $container = new DataContainer();
        $container->version = 1;
        
        $config = require __DIR__.'/../../config/config.php';
        $collection = new InputCollection($inputs, new ActionFactory($config['actions']));
        
        $blueprint = new Blueprint('contacts', function(Blueprint $table) use ($collection, $container) {
            $container->table = $table;
            $collection->execute(LaravelMigration::class, $container);
        });
        
        $this->assertCount(2, $blueprint->getColumns());
        
    }
    
    /** @test */
    public function when_no_migration_action_is_passed_to_the_input_the_type_string_is_used()
    {
        $migration = new LaravelMigration();
        
        $name = new TextInput('name', 'Name');
        
        $inputs = [$name];
        
        $blueprint = new Blueprint('contacts', function(Blueprint $table) use ($inputs, $migration) {
            
            $container = new DataContainer();
            $container->table = $table;
            $container->version = 1;
            
            $migration->execute($inputs, $container);
        });
        
        $this->assertCount(1, $blueprint->getColumns());
        $this->assertEquals("string", $blueprint->getColumns()[0]->type);
    }
    
    /** @test */
    public function an_array_with_type_as_a_key_can_be_passed_as_a_value_to_the_action()
    {
        $migration = new LaravelMigration();
        
        $name = new TextInput('name', 'Name');
        $name->setAction(new DataContainer(LaravelMigration::class, [
            'type' => 'string'
        ]));
        
        $email = new TextInput('email', 'Email');
        $email->setAction(new DataContainer(LaravelMigration::class, [
            'type' => function($table, $input){
                return $table->text($input->getName())->nullable();
            }
        ]));
        
        $inputs = [$name, $email];
        
        $blueprint = new Blueprint('contacts', function(Blueprint $table) use ($inputs, $migration) {
            
            $container = new DataContainer();
            $container->table = $table;
            $container->version = 1;
            
            $migration->execute($inputs, $container);
        });
        
        $this->assertCount(2, $blueprint->getColumns());
    }
    
    /** @test */
    public function a_callback_can_be_passed_as_value_to_the_action()
    {
        $migration = new LaravelMigration();
        
        $name = new TextInput('name', 'Name');
        $name->setAction(new DataContainer(LaravelMigration::class, function($table, $input){
            return $table->string($input->getName())->nullable();
        }));
        
        $inputs = [$name];
        
        $blueprint = new Blueprint('contacts', function(Blueprint $table) use ($inputs, $migration) {
            
            $container = new DataContainer();
            $container->table = $table;
            $container->version = 1;
            
            $migration->execute($inputs, $container);
        });
        
        $this->assertCount(1, $blueprint->getColumns());
        
    }
}
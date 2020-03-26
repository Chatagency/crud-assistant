<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\Actions\LaravelMigration;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Modifiers\UniqueMigrationModifier;
use Chatagency\CrudAssistant\Modifiers\UnsignedMigrationModifier;
use Illuminate\Database\Schema\Blueprint;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LaravelMigrationTest extends TestCase
{
    /** @test */
    public function a_migration_action_can_be_executed_using_an_array_of_inputs()
    {
        $migration = new LaravelMigration();

        $name = new TextInput('name', 'Name');
        $name->setRecipe(LaravelMigration::class, [
            'type' => 'text',
        ]);

        $email = new TextInput('email', 'Email');
        $email->setRecipe(LaravelMigration::class, [
            'nullable' => true,
            'unique' => true,
        ]);

        $description = new TextInput('description', 'Description');
        $description->setRecipe(LaravelMigration::class, [
            'type' => 'longText',
        ]);

        $inputs = [$name, $email, $description];

        $container = new DataContainer();
        $container->version = 1;

        $blueprint = new Blueprint('contacts', function (Blueprint $table) use ($inputs, $migration, $container) {
            $container->table = $table;
            $migration->execute($inputs, $container);
        });

        $this->assertCount(3, $blueprint->getColumns());
    }

    /** @test */
    public function a_migration_action_can_be_created_using_a_collection()
    {
        $migration = new LaravelMigration();

        $name = new TextInput('name', 'Name');
        $name->setRecipe(LaravelMigration::class, [
            'type' => 'text',
        ]);

        $email = new TextInput('email', 'Email');
        $email->setRecipe(LaravelMigration::class, [
            'nullable' => true,
        ]);

        $inputs = [$name, $email];

        $container = new DataContainer();
        $container->version = 1;

        $config = require __DIR__.'/../../config/config.php';
        $collection = new InputCollection($inputs, new ActionFactory($config['actions']));

        $blueprint = new Blueprint('contacts', function (Blueprint $table) use ($collection, $container) {
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

        $blueprint = new Blueprint('contacts', function (Blueprint $table) use ($inputs, $migration) {
            $container = new DataContainer();
            $container->table = $table;
            $container->version = 1;

            $migration->execute($inputs, $container);
        });

        $this->assertCount(1, $blueprint->getColumns());
        $this->assertEquals('string', $blueprint->getColumns()[0]->type);
    }

    /** @test */
    public function an_array_with_type_as_a_key_can_be_passed_as_a_value_to_the_action()
    {
        $migration = new LaravelMigration();

        $name = new TextInput('name', 'Name');
        $name->setRecipe(LaravelMigration::class, [
            'type' => 'string',
        ]);

        $inputs = [$name];

        $blueprint = new Blueprint('contacts', function (Blueprint $table) use ($inputs, $migration) {
            $container = new DataContainer();
            $container->table = $table;
            $container->version = 1;

            $migration->execute($inputs, $container);
        });

        $this->assertCount(1, $blueprint->getColumns());
    }

    /** @test */
    public function a_callback_can_be_passed_as_value_to_the_action_or_as_the_type()
    {
        $migration = new LaravelMigration();

        $name = new TextInput('name', 'Name');
        $name->setRecipe(LaravelMigration::class, function ($table, $input) {
            return $table->string($input->getName())->nullable();
        });
        
        $email = new TextInput('email', 'Email');
        $email->setRecipe(LaravelMigration::class, [
            'type' => function ($table, $input) {
                return $table->string($input->getName())->nullable();
            }
        ]);

        $inputs = [$name, $email];

        $blueprint = new Blueprint('contacts', function (Blueprint $table) use ($inputs, $migration) {
            $container = new DataContainer();
            $container->table = $table;
            $container->version = 1;

            $migration->execute($inputs, $container);
        });
        
        $this->assertCount(2, $blueprint->getColumns());
    }

    /** @test */
    public function if_a_param_is_missing_an_exception_is_thrown()
    {
        $migration = new LaravelMigration();

        $name = new TextInput('name', 'Name');
        $name->setRecipe(LaravelMigration::class, [
            'type' => 'text',
        ]);
        $inputs = [$name];

        $container = new DataContainer();
        $container->version = 1;

        $this->expectException(InvalidArgumentException::class);

        $blueprint = new Blueprint('contacts', function (Blueprint $table) use ($inputs, $migration, $container) {
            /*
             * Table is not passed
             */
            // $container->table = $table;
            $migration->execute($inputs, $container);
        });
    }
    
    /** @test */
    public function modifiers_can_be_applied_to_an_input()
    {
        $migration = new LaravelMigration();
        
        $inputName = 'email';
        
        $email = new TextInput($inputName, 'Email');
        $email->setRecipe(LaravelMigration::class, [
            'type' => 'string',
            'modifiers' => [
                UniqueMigrationModifier::class => new DataContainer([]),
            ]
        ]);
        
        $inputs = [$email];

        $blueprint = new Blueprint('contacts', function (Blueprint $table) use ($inputs, $migration) {
            $container = new DataContainer();
            $container->table = $table;
            $container->version = 1;

            $migration->execute($inputs, $container);
        });
        
        $columns = $blueprint->getColumns();
        
        $this->assertCount(1, $columns);
        
        $emailAttributes = $columns[0]->getAttributes();
        
        $this->assertEquals($inputName, $emailAttributes['name']);
        $this->assertTrue($emailAttributes['unique']);
        
    }
    
    /** @test */
    public function multiple_modifiers_can_be_applied_to_a_an_input()
    {
        $migration = new LaravelMigration();
        
        $inputName = 'email';
        
        $email = new TextInput($inputName, 'Email');
        $email->setRecipe(LaravelMigration::class, [
            'type' => 'string',
            'modifiers' => [
                UniqueMigrationModifier::class => new DataContainer([]),
                UnsignedMigrationModifier::class => new DataContainer([]),
            ]
        ]);
        
        $inputs = [$email];

        $blueprint = new Blueprint('contacts', function (Blueprint $table) use ($inputs, $migration) {
            $container = new DataContainer();
            $container->table = $table;
            $container->version = 1;

            $migration->execute($inputs, $container);
        });
        
        $columns = $blueprint->getColumns();
        
        $this->assertCount(1, $columns);
        
        $emailAttributes = $columns[0]->getAttributes();
        
        $this->assertEquals($inputName, $emailAttributes['name']);
        $this->assertTrue($emailAttributes['unique']);
        $this->assertTrue($emailAttributes['unsigned']);
    }

    /** @test */
    public function modifiers_can_be_also_instantiated_instead()
    {
        $migration = new LaravelMigration();
        
        $inputName = 'email';
        
        $email = new TextInput($inputName, 'Email');
        $email->setRecipe(LaravelMigration::class, [
            'type' => 'string',
            'modifiers' => [
                new UnsignedMigrationModifier(new DataContainer([])),
                UniqueMigrationModifier::class => new DataContainer([]),
            ]
        ]);
        
        $inputs = [$email];

        $blueprint = new Blueprint('contacts', function (Blueprint $table) use ($inputs, $migration) {
            $container = new DataContainer();
            $container->table = $table;
            $container->version = 1;

            $migration->execute($inputs, $container);
        });
        
        $columns = $blueprint->getColumns();
        
        $this->assertCount(1, $columns);
        
        $emailAttributes = $columns[0]->getAttributes();
        
        $this->assertEquals($inputName, $emailAttributes['name']);
        $this->assertTrue($emailAttributes['unique']);
        $this->assertTrue($emailAttributes['unsigned']);
    }
    
    /** @test */
    public function an_input_can_be_ignored_by_the_migration_action_action()
    {
        $migration = new LaravelMigration();
        
        $name = new TextInput('name', 'Name');
        $name->setRecipe(LaravelMigration::class, [
            'type' => 'text',
        ]);
        
        $id = new TextInput('id', 'Id');
        $id->setType('hidden');
        
        $id->setRecipe(LaravelMigration::class, [
            'ignore' => true,
        ]);
        
        $inputs = [$name, $id];

        $blueprint = new Blueprint('contacts', function (Blueprint $table) use ($inputs, $migration) {
            $container = new DataContainer();
            $container->table = $table;
            $container->version = 1;

            $migration->execute($inputs, $container);
        });
        
        $this->assertCount(1, $blueprint->getColumns());
    }
}

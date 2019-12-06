<?php

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\Actions\LaravelValidationRules;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class InputCollectionTest extends TestCase
{
    public function getCollection(array $inputs = [])
    {
        /**
         * Laravel config() is not available
         * inside the package.
         *
         * @var array
         */
        $config = require __DIR__.'/../config/config.php';

        return new InputCollection($inputs, new ActionFactory($config['actions']));
    }

    /** @test */
    public function a_collection_can_have_multiple_inputs()
    {
        $form = $this->getCollection();

        $form->addInput(new TextInput('name', 'Name'));
        $this->assertEquals($form->count(), 1);

        $form->addInput(new TextInput('email', 'Email'));
        $this->assertEquals($form->count(), 2);
    }

    /** @test */
    public function inputs_can_be_accessed_using_get_input()
    {
        $form = $this->getCollection();

        $form->addInput(new TextInput('name', 'Name'));
        $name = $form->getInput('name');
        $this->assertEquals('name', $name->getName());
        $this->assertCount(1, $form->getInputs());
    }

    /** @test */
    public function an_exception_is_thrown_if_a_non_existing_input_is_accessed()
    {
        $this->expectException(InvalidArgumentException::class);
        $form = $this->getCollection();
        $name = $form->getInput('name');
    }

    /** @test */
    public function an_input_can_be_removed_from_the_collection()
    {
        $form = $this->getCollection();

        $form->addInput(new TextInput('name', 'Name'));
        $this->assertEquals(1, $form->count());

        $form->removeInput('name');
        $this->assertEquals(0, $form->count());
    }

    /** @test */
    public function an_action_can_be_executed_from_a_collection()
    {
        $name = new TextInput('name', 'Name');
        $name->setAction(LaravelValidationRules::class, [
            'required',
            'max:250',
        ]);

        $email = new TextInput('email', 'Email');
        $email->setAction(LaravelValidationRules::class, [
            'required',
            'email',
        ]);

        $form = $this->getCollection([$name, $email]);
        $validation = $form->execute(LaravelValidationRules::class);

        $this->assertCount(2, $validation);
        $this->assertNotFalse($validation);
    }

    /** @test */
    public function a_collection_can_contain_inputs_with_or_without_actions()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $email->setAction(LaravelValidationRules::class, [
            'required',
            'email',
        ]);

        $form = $this->getCollection([$name, $email]);
        $validation = $form->execute(LaravelValidationRules::class);

        $this->assertCount(1, $validation);
        $this->assertNotFalse($validation);
    }

    /** @test */
    public function a_collection_can_return_an_array_of_the_input_names()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');

        $form = $this->getCollection([$name, $email]);
        $names = $form->getInputNames();

        $this->assertCount(2, $names);
        $this->assertEquals($name->getName(), $names[0]);
    }
}

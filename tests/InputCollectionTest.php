<?php

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\Actions\LaravelValidationRules;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class InputCollectionTest extends TestCase
{

    /** @test */
    public function a_collection_can_have_multiple_inputs()
    {
        $form = new InputCollection([]);

        $form->addInput(new TextInput('name', 'Name'));
        $this->assertEquals($form->count(), 1);

        $form->addInput(new TextInput('email', 'Email'));
        $this->assertEquals($form->count(), 2);
    }

    /** @test */
    public function inputs_can_be_accessed_using_get_input()
    {
        $form = new InputCollection([]);

        $form->addInput(new TextInput('name', 'Name'));
        $name = $form->getInput('name');
        $this->assertEquals('name', $name->getName());
        $this->assertCount(1, $form->getInputs());
    }

    /** @test */
    public function an_exception_is_thrown_if_a_non_existing_input_is_accessed()
    {
        $this->expectException(InvalidArgumentException::class);
        $form = new InputCollection([]);
        $name = $form->getInput('name');
    }

    /** @test */
    public function an_input_can_be_removed_from_the_collection()
    {
        $form = new InputCollection([]);

        $form->addInput(new TextInput('name', 'Name'));
        $this->assertEquals(1, $form->count());

        $form->removeInput('name');
        $this->assertEquals(0, $form->count());
    }

    /** @test */
    public function an_action_can_be_executed_from_a_collection()
    {
        $name = new TextInput('name', 'Name');
        $name->setRecipe(LaravelValidationRules::class, [
            'required',
            'max:250',
        ]);

        $email = new TextInput('email', 'Email');
        $email->setRecipe(LaravelValidationRules::class, [
            'required',
            'email',
        ]);

        $form = new InputCollection([$name, $email]);
        $validation = $form->execute(new LaravelValidationRules);

        $this->assertCount(2, $validation);
        $this->assertNotFalse($validation);
    }

    /** @test */
    public function a_collection_can_contain_inputs_with_or_without_actions()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $email->setRecipe(LaravelValidationRules::class, [
            'required',
            'email',
        ]);

        $form = new InputCollection([$name, $email]);
        $validation = $form->execute(new LaravelValidationRules);

        $this->assertCount(1, $validation);
        $this->assertNotFalse($validation);
    }

    /** @test */
    public function a_collection_can_return_an_array_of_the_input_names()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');

        $form = new InputCollection([$name, $email]);
        $names = $form->getInputNames();

        $this->assertCount(2, $names);
        $this->assertContains($name->getName(), $names);
        $this->assertContains($email->getName(), $names);
    }

    /** @test */
    public function a_collection_can_return_an_array_of_the_input_labels()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');

        $form = new InputCollection([$name, $email]);
        $labels = $form->getInputLabels();

        $this->assertCount(2, $labels);
        $this->assertContains($name->getLabel(), $labels);
        $this->assertContains($email->getLabel(), $labels);
    }

    /** @test */
    public function a_partial_input_collection_can_be_created()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection([$name, $email, $address]);

        $this->assertCount(3, $form->getInputNames());

        $form->setPartialCollection(['name', 'email']);

        $this->assertCount(2, $form->getInputNames());

    }

    /** @test */
    public function a_sub_collection_can_be_accessed_using_get_partial_collection()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection([$name, $email, $address]);
        $form->setPartialCollection(['name', 'email']);

        $this->assertCount(2, $form->getPartialCollection());

    }

    /** @test */
    public function if_an_empty_array_is_passed_when_creating_a_sub_collection_an_exception_is_thrown()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection([$name, $email, $address]);

        $this->assertCount(3, $form->getInputNames());

        $this->expectException(Exception::class);

        $form->setPartialCollection([]);

    }

    /** @test */
    public function if_no_inputs_have_been_set_an_exception_is_thrown_when_trying_create_an_sub_collection()
    {
        $form = new InputCollection([]);

        $this->expectException(Exception::class);

        $form->setPartialCollection(['name']);

    }

    /** @test */
    public function if_an_input_is_removed_from_the_collection_it_is_also_removed_from_the_sub_collection()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection([$name, $email, $address]);
        $form->setPartialCollection(['name', 'email']);
        $form->removeInput('name');

        $this->assertCount(2, $form->getInputs(true));
        $this->assertCount(1, $form->getInputs());

    }
}

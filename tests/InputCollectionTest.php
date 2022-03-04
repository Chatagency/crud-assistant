<?php

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Actions\PrepareCleanupAction;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Recipes\LabelValueRecipe;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class InputCollectionTest extends TestCase
{

    /** @test */
    public function a_collection_can_have_multiple_inputs()
    {
        $form = new InputCollection();

        $form->addInput(new TextInput('name', 'Name'));
        $this->assertEquals($form->count(), 1);

        $form->addInput(new TextInput('email', 'Email'));
        $this->assertEquals($form->count(), 2);
    }

    /** @test */
    public function inputs_can_be_accessed_using_get_input()
    {
        $form = new InputCollection();

        $form->addInput(new TextInput('name', 'Name'));
        $name = $form->getInput('name');
        $this->assertEquals('name', $name->getName());
        $this->assertCount(1, $form->getInputs());
    }

    /** @test */
    public function isset_can_be_used_to_check_if_an_input_exists()
    {
        $form = new InputCollection();

        $form->addInput(new TextInput('name', 'Name'));
        $form->addInput(new TextInput('email', 'Email'));

        $this->assertTrue($form->isset('name'));
        $this->assertFalse($form->isset('does_no_exist'));
    }

    /** @test */
    public function an_exception_is_thrown_if_a_non_existing_input_is_accessed()
    {
        $this->expectException(InvalidArgumentException::class);
        $form = new InputCollection();
        $form->getInput('name');
    }

    /** @test */
    public function an_input_can_be_removed_from_the_collection()
    {
        $form = new InputCollection();

        $form->addInput(new TextInput('name', 'Name'));
        $this->assertEquals(1, $form->count());

        $form->removeInput('name');
        $this->assertEquals(0, $form->count());
    }

    /** @test */
    public function an_action_can_be_executed_from_a_collection()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');

        $form = new InputCollection();
        $form->setInputs([$name, $email]);

        $model = new DataContainer([
            'name' => 'John',
            'email' => 'john#@email.com',
        ]);

        $labelValue = $form->execute(
            LabelValueAction::make()->setModel($model)
        );

        $this->assertCount(2, $labelValue);
    }

    /** @test */
    public function if_ignore_is_set_on_the_recipe_of_an_input_that_input_will_not_be_sent_to_the_action()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $email->setRecipe(
            LabelValueRecipe::make()
                ->ignore()
        );

        $form = new InputCollection();
        $form->setInputs([$name, $email]);

        $model = new DataContainer([
            'name' => 'John',
            'email' => 'john#@email.com',
        ]);

        $labelValue = $form->execute(
            LabelValueAction::make()->setModel($model)
        );

        $this->assertCount(1, $labelValue);
    }

    /** @test */
    public function a_collection_can_return_an_array_of_the_input_names()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');

        $form = new InputCollection();
        $form->setInputs([$name, $email]);
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

        $form = new InputCollection();
        $form->setInputs([$name, $email]);
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

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address]);

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

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address]);

        $form->setPartialCollection(['name', 'email']);

        $this->assertCount(2, $form->getPartialCollection());

    }

    /** @test */
    public function if_an_empty_array_is_passed_when_creating_a_sub_collection_an_exception_is_thrown()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address]);

        $this->assertCount(3, $form->getInputNames());

        $this->expectException(Exception::class);

        $form->setPartialCollection([]);

    }

    /** @test */
    public function if_no_inputs_have_been_set_an_exception_is_thrown_when_trying_create_an_sub_collection()
    {
        $form = new InputCollection();

        $this->expectException(Exception::class);

        $form->setPartialCollection(['name']);

    }

    /** @test */
    public function if_an_input_is_removed_from_the_collection_it_is_also_removed_from_the_sub_collection()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address]);

        $form->setPartialCollection(['name', 'email']);

        $this->assertCount(3, $form->getInputs(true));
        $this->assertCount(2, $form->getInputs());

        $form->removeInput('name');

        $this->assertCount(2, $form->getInputs(true));
        $this->assertCount(1, $form->getInputs());

    }

    /** @test */
    public function the_input_collection_is_iterable()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address]);
        
        foreach($form as $input) {
            $this->assertInstanceOf(InputInterface::class, $input);
        }
    }

    /** @test */
    public function an_input_collection_can_contain_other_input_collection()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $collection = new InputCollection('secondary_info');
        $collection->setInputs([
            new TextInput('age', 'Your age'),
        ]);

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address, $collection]);

        $this->assertCount(4, $form);
        $this->assertInstanceOf(InputCollection::class, $form->getInput('secondary_info'));
    }

    /** @test */
    public function if_ignore_is_set_on_the_recipe_of_an_input_and_control_recursion_is_set_to_true_the_action_must_handle_ignored_inputs_on_internal_collections()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');
        $age = new TextInput('age', 'Your age');

        $age->setRecipe(
            LabelValueRecipe::make()
                ->ignore()
        );

        $collection = new InputCollection('secondary_info');
        $collection->setInputs([
            $address,
            $age,
        ]);

        $form = new InputCollection();
        $form->setInputs([$name, $email, $collection]);

        $model = new DataContainer([
            'name' => 'John',
            'email' => 'john#@email.com',
            'address' => '123 6 street',
            'age' => 26,
        ]);

        $output = $form->execute(
            LabelValueAction::make()
                ->setModel($model)
                ->setIgnore(false)
                ->setControlsRecursion(true)
        );

        $this->assertCount(4, $output);
    }

    /** @test */
    public function if_process_internal_collection_is_true_the_internal_collection_is_processed_like_a_normal_input()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');
        $age = new TextInput('age', 'Your age');

        $collection = new InputCollection('collection_value');
        $collection->setInputs([
            $address,
            $age,
        ]);

        $form = new InputCollection();
        $form->setInputs([$name, $email, $collection]);

        $model = new DataContainer([
            'name' => 'John',
            'email' => 'john#@email.com',
            'address' => '123 6 street',
            'age' => 26,
            'collection_value' => 'This is your collection value',
        ]);

        $output = $form->execute(
            LabelValueAction::make()
                ->setModel($model)
        );

        $this->assertCount(4, $output);

        $output2 = $form->execute(
            LabelValueAction::make()
                ->setModel($model)
                ->setProcessInternalCollection(true)
        );

        $this->assertCount(5, $output2);
    }
    
    /** @test */
    public function the_prepare_and_cleanup_execution_can_be_disabled()
    {
        $collection = new InputCollection('collection_1');
        $collection
            ->setInputs([
                new TextInput('name', 'Name')
            ]);

        $output = $collection->execute(
            new PrepareCleanupAction()
        );

        $this->assertCount(3, $output);

        $collection2 = new InputCollection('collection_1');
        $collection2
            ->setInputs([
                new TextInput('name', 'Name')
            ])
            ->disablePrepare()
            ->disableCleanup();
        
        $output2 = $collection2->execute(
            new PrepareCleanupAction()
        );

        $this->assertCount(1, $output2);
        
    }

}

<?php

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Recipes\FilterRecipe;
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

        $labelValue = $form->execute(new LabelValueAction(
            new DataContainer(['model' => $model])
        ));

        $this->assertCount(2, $labelValue);
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
        
        foreach($form as $inputName => $input) {
            $this->assertInstanceOf(InputInterface::class, $input);
        }
    }

    /** @test */
    public function an_input_collection_can_contain_one_or_more_input_collection()
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
    public function an_input_collection_with_internal_collections_save_output_in_tree_if_the_is_tree_option_is_true()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'Your Address');

        $internal = new InputCollection('secondary_info');
        $internal->setInputs([
            new TextInput('age', 'Your age'),
        ]);

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address, $internal,]);
        
        $runtime = new DataContainer([
            'model' => new DataContainer([
                'name' => "Victor Sánchez",
                'email' => 'email@email.com',
                'address' => 'Lorem ipsum dolor sit.',
                'age' => 35,
            ])
        ]);

        $output = $form->execute(new LabelValueAction($runtime));
        
        $this->assertCount(4, $output);
        $this->assertInstanceOf(DataContainer::class, $output->secondary_info);
        $this->assertCount(1, $output->secondary_info);
        $this->assertEquals($runtime->model->age, $output->secondary_info->{$internal->getInput('age')->getLabel()});
    }

    /** @test */
    public function an_input_collection_with_internal_collections_without_the_tree_option_goes_with_the_normal_flow()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'Your Address');

        $internal = new InputCollection('secondary_info');

        $ageInput = new TextInput('age', 'Your age');
        $ageInput->setRecipe(
            (new FilterRecipe([
                'filter' => true
            ]))
        );

        $internal->setInputs([
            $ageInput,
        ]);

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address, $internal,]);
        
        $runtime = new DataContainer([
            'data' => [
                'name' => "Victor Sánchez",
                'email' => 'email@email.com',
                'address' => 'Lorem ipsum dolor sit.',
                'age' => 35,
            ]
        ]);

        $action = (new FilterAction($runtime))
            /**
             * Delegates execution to the 
             * input collection
             */
            ->setControlsExecution(false);

        $output = $form->execute($action);

        // dumpIt($output);
        
        $this->assertCount(3, $output->data);
        $this->assertArrayHasKey('name', $output->data);
        $this->assertArrayNotHasKey('age', $output->data);
    }

    /** @test */
    public function if_an_internal_collection_does_not_have_a_name_an_exception_is_thrown()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'Your Address');

        /**
         * Collection has no name
         */
        $internal = new InputCollection();
        $internal->setInputs([
            new TextInput('age', 'Your age'),
        ]);

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address, $internal,]);
        
        $runtime = new DataContainer([
            'model' => new DataContainer([
                'name' => "Victor Sánchez",
                'email' => 'email@email.com',
                'address' => 'Lorem ipsum dolor sit.',
                'age' => 35,
            ])
        ]);

        $this->expectException(\Exception::class);

        $form->execute(new LabelValueAction($runtime));
    }
    
    /** @test */
    public function an_action_can_take_control_of_the_whole_execution_using_execute_all()
    {
        /**
         * If the action must take control of the whole
         * execution the method executeAll must be 
         * used or the option controlsExecution
         * must be set to true
         */

        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'Your Address');
        $address->setRecipe(new FilterRecipe([
            'filter' => true
        ]));

        $internal = new InputCollection('secondary_info');
        $internal->setInputs([
            new TextInput('age', 'Your age'),
        ]);

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address, $internal,]);
        
        $runtime = new DataContainer([
            'data' => [
                'name' => "Victor Sánchez",
                'email' => 'email@email.com',
                'address' => 'Lorem ipsum dolor sit.',
                'age' => 35,
            ]
        ]);

        $output = $form->executeAll(new FilterAction($runtime));
        $output2 = $form->execute(new FilterAction($runtime));

        $this->assertEquals($output, $output2);

        $this->assertCount(3, $output->data);
        $this->assertContains($runtime->data['name'], $output->data);
        $this->assertNotContains($runtime->data['address'], $output->data);
    }

}

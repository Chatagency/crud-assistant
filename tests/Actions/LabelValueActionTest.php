<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Modifiers\BooleanModifier;
use Chatagency\CrudAssistant\Recipes\LabelValueRecipe;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LabelValueActionTest extends TestCase
{
    /** @test */
    public function make_can_be_used_to_get_an_instance_of_filter_action()
    {
        $recipe = LabelValueAction::make();

        $this->assertInstanceOf(LabelValueAction::class, $recipe);
    }
    
    /** @test */
    public function all_actions_have_a_generic_data_setter_and_getter()
    {
        $recipe = LabelValueAction::make();

        $data = [
            'name' => 'John Doe'
        ];
        $recipe->setGenericData(new DataContainer($data));

        $this->assertEquals($data['name'], $recipe->getGenericData()->name);
    }
    
    /** @test */
    public function the_label_value_action_returns_an_container_with_labels_as_keys()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $inputs = [$name, $email];

        $model = new DataContainer([
            'name' => 'John Doe',
            'email' => 'john@email.com',
        ]);
        
        $action = new LabelValueAction();
        $action->setModel($model);
        
        $action->prepare();
        foreach($inputs as $input) {
            $action->execute($input);
        }
        $output = $action->getOutput();

        $emailName = $email->getName();
        $emailLabel = $email->getLabel();

        $this->assertCount(2, $output);
        $this->assertEquals($model->$emailName, $output->$emailLabel);

    }

    /** @test */
    public function if_the_model_is_not_specified_an_exception_is_throw()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $inputs = [$name, $email];

        $this->expectException(InvalidArgumentException::class);

        $action =  new LabelValueAction(new DataContainer());
        
        $action->prepare();
        foreach($inputs as $input) {
            $action->execute($input);
        }
    }

    /** @test */
    public function an_input_can_be_ignored_by_the_label_value_action()
    {
        $name = new TextInput('name', 'Name');

        $recipe = (new LabelValueRecipe())->ignore();
        $name->setRecipe($recipe);

        $email = new TextInput('email', 'Email');
        $inputs = [$name, $email];

        $model = new DataContainer([
            'name' => 'John Doe',
            'email' => 'john@email.com',
        ]);

        $action =  new LabelValueAction();
        $action->setModel($model);
        
        $action->prepare();
        foreach($inputs as $input) {
            $action->execute($input);
        }
        $output = $action->getOutput();

        $this->assertCount(1, $output);
        $this->assertNotContains($model->name, $output);

    }

    /** @test */
    public function a_closure_can_be_used_to_alter_the_label_on_the_label_value_action()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');

        $nameFormat = "The %s is";

        $nameRecipe = new LabelValueRecipe();
        $nameRecipe->label = function(Input $input, DataContainer $params) use ($nameFormat) {
            return sprintf($nameFormat, $input->getLabel());
        };

        $name->setRecipe($nameRecipe);

        $emailFormat = "The address is %s";

        $emailRecipe = new LabelValueRecipe();
        $emailRecipe->value = function(Input $input, $model) use ($emailFormat) {
            return sprintf($emailFormat, $model->email);
        };

        $email->setRecipe($emailRecipe);

        $inputs = [$name, $email];

        $model = new DataContainer([
            'name' => 'John Doe',
            'email' => 'john@email.com',
        ]);
        
        $action =  (new LabelValueAction());
        $action->setModel($model);
        
        $action->prepare();
        foreach($inputs as $input) {
            $action->execute($input);
        }
        $output = $action->getOutput();

        $nameLabel = sprintf($nameFormat, $name->getLabel());
        $emailLabel = $email->getLabel();

        $this->assertCount(2, $output);
        $this->assertEquals($output->$nameLabel, $model->name);
        $this->assertNotEquals($output->$emailLabel, $model->email);
        
    }
    
    /** @test */
    public function modifiers_can_be_added_to_the_label_value_action_recipe()
    {
        $name = new TextInput('name', 'Name');
        $accept = new TextInput('accept', 'Accept Terms');

        $modifierData = new DataContainer([
            'trueLabel' => 'I Accept'
        ]);

        $recipe = new LabelValueRecipe();
        $recipe->setModifiers([
            new BooleanModifier($modifierData)
        ]);
        $accept->setRecipe($recipe);

        $inputs = [$name, $accept];

        $model = new DataContainer([
            'name' => 'John Doe',
            'accept' => true,
        ]);

        $action =  new LabelValueAction();
        $action->setModel($model);
        
        $action->prepare();
        foreach($inputs as $input) {
            $action->execute($input);
        }
        $output = $action->getOutput();

        $this->assertEquals($modifierData->trueLabel, $output->{$accept->getLabel()});

    }

    /** @test */
    public function if_an_invalid_value_is_passed_to_the_recipe_an_exception_is_thrown()
    {
        $this->expectException(\Exception::class);
        
        $recipe = (new LabelValueRecipe());
        $recipe->NotValid = true;
        
    }
    
}
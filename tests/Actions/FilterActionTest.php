<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Recipes\FilterRecipe;
use PHPUnit\Framework\TestCase;

class FilterActionTest extends TestCase
{

    /** @test */
    public function make_can_be_used_to_get_an_instance_of_filter_action()
    {
        $recipe = FilterAction::make();

        $this->assertInstanceOf(FilterAction::class, $recipe);
    }

    /** @test */
    public function all_actions_have_a_generic_data_setter_and_getter()
    {
        $recipe = FilterAction::make();

        $data = [
            'name' => 'John Doe'
        ];
        $recipe->setGenericData(new DataContainer($data));

        $this->assertEquals($data['name'], $recipe->getGenericData()->name);
    }
    
    /** @test */
    public function a_filter_action_is_used_to_exclude_input_data_from_dataset()
    {
        $filter = new FilterAction();

        $name = new TextInput('name', 'Name');
        
        $email = new TextInput('email', 'Email');

        $recipe = new FilterRecipe();
        $recipe->filter = true;
        
        $email->setRecipe($recipe);
        
        $description = new TextInput('description', 'Description');
        
        $crud = CrudAssistant::make([$email, $name, $description]);
        
        $filter = new FilterAction();
        $filter->setData([
            'name' => "Victor Sánchez",
            'email' => 'email@email.com',
            'description' => 'Lorem ipsum dolor sit',
        ]);

        
        $filtered = $crud->execute($filter);

        $this->assertCount(2, $filtered->data);
        $this->assertFalse(isset($filtered->data[$email->getName()]));

    }
    
    /** @test */
    public function a_closure_can_be_passed_as_a_value_instead_of_an_array_to_the_filter_action()
    {
        $name = new TextInput('name', 'Name');
        
        $email = new TextInput('email', 'Email');
        
        $recipe = new FilterRecipe();
        $recipe->callback = function($input, $data){
            unset($data[$input->getName()]);
            return $data;
        };

        $email->setRecipe($recipe);
        
        $description = new TextInput('description', 'Description');
        
        $inputs = [$name, $email, $description];
        
        $filter = new FilterAction();
        $filter->setData([
            'name' => "Victor Sánchez",
            'email' => 'email@email.com',
            'description' => 'Lorem ipsum dolor sit',
        ]);

        $filter->prepare();
        foreach($inputs as $input) {
            $filter->executeOne($input);
        }
        $filtered = $filter->getOutput();

        $this->assertCount(2, $filtered->data);
        $this->assertFalse(isset($filtered->data[$email->getName()]));
    }

    /** @test */
    public function if_ignore_if_empty_is_passed_to_the_filter_action_that_item_is_also_filtered()
    {
        $name = new TextInput('name', 'Name');
        
        $email = new TextInput('email', 'Email');

        $recipe = new FilterRecipe();
        $recipe->ignoreIfEmpty = true;
        
        $email->setRecipe($recipe);
        
        $description = new TextInput('description', 'Description');
        
        $inputs = [$name, $email, $description];

        $filter = new FilterAction();
        $filter->setData([
            'name' => "Victor Sánchez",
            'email' => '',
            'description' => 'Lorem ipsum dolor sit',
        ]);

        $filter->prepare();
        foreach($inputs as $input) {
            $filter->executeOne($input);
        }
        $filtered = $filter->getOutput();

        $this->assertCount(2, $filtered->data);
    }

    /** @test */
    public function if_data_is_missing_or_empty_an_exception_is_thrown ()
    {
        $this->expectException(\Exception::class);
        
        $filter = new FilterAction();
        $filter->prepare();
        
    }

    /** @test */
    public function if_an_invalid_value_is_passed_to_the_recipe_an_exception_is_thrown()
    {
        $this->expectException(\Exception::class);
        
        $recipe = new FilterRecipe();
        $recipe->NotValid = true;
        
    }

}
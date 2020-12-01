<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\Actions\Filter;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Recipe;
use Chatagency\Recipes\FilterRecipe;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    /** @test */
    public function a_filter_action_is_used_to_exclude_input_data_from_dataset()
    {
        $filter = new Filter();

        $name = new TextInput('name', 'Name');
        
        $email = new TextInput('email', 'Email');

        $recipe = new FilterRecipe();
        $recipe->filter = true;
        
        $email->setRecipe($recipe);
        
        $description = new TextInput('description', 'Description');
        
        $inputs = [$email, $name, $description];
        
        $container = new DataContainer();
        $container->data = [
            'name' => "Victor Sánchez",
            'email' => 'email@email.com',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        ];

        $filter = new Filter($container);

        $output = new DataContainer();
        foreach($inputs as $input) {
            $filtered = $filter->execute($input, $output);
        }

        $this->assertCount(2, $filtered->data);
        $this->assertFalse(isset($filtered->data[$email->getName()]));

    }
    
    /** @test */
    public function a_closure_can_be_passed_as_a_value_instead_of_an_array_to_the_filter_action()
    {
        $name = new TextInput('name', 'Name');
        
        $email = new TextInput('email', 'Email');
        
        $recipe = new FilterRecipe();
        $recipe->closure = function($input, $params, $data){
            unset($data[$input->getName()]);
            return $data;
        };

        $email->setRecipe($recipe);
        
        $description = new TextInput('description', 'Description');
        
        $inputs = [$name, $email, $description];
        
        $container = new DataContainer();
        $container->data = [
            'name' => "Victor Sánchez",
            'email' => 'email@email.com',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        ];

        $filter = new Filter($container);

        $output = new DataContainer();
        foreach($inputs as $input) {
            $filtered = $filter->execute($input, $output);
        }

        $this->assertCount(2, $filtered->data);
        $this->assertFalse(isset($filtered->data[$email->getName()]));
    }

    /** @test */
    public function if_ignore_if_empty_is_passed_to_the_filter_action_that_item_is_also_filtered()
    {
        $name = new TextInput('name', 'Name');
        
        $email = new TextInput('email', 'Email');

        $recipe = (new FilterRecipe())
            ->ignore();
        
        $email->setRecipe($recipe);
        
        $description = new TextInput('description', 'Description');
        
        $inputs = [$name, $email, $description];
        
        $container = new DataContainer();
        $container->data = [
            'name' => "Victor Sánchez",
            'email' => '',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        ];

        $filter = new Filter($container);

        $output = new DataContainer();
        foreach($inputs as $input) {
            $filtered = $filter->execute($input, $output);
        }

        $this->assertCount(2, $filtered->data);
    }

}
<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\Actions\Filter;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Inputs\TextInput;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    /** @test */
    public function a_filter_action_is_used_to_exclude_input_data_from_dataset()
    {
        $filter = new Filter();

        $name = new TextInput('name', 'Name');
        
        $email = new TextInput('email', 'Email');
        $email->setRecipe(Filter::class, [
            'filter' => true
        ]);
        
        $description = new TextInput('description', 'Description');
        
        $inputs = [$name, $email, $description];
        
        $container = new DataContainer();
        $container->data = [
            'name' => "Victor Sánchez",
            'email' => 'email@email.com',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        ];

        $filtered = $filter->execute($inputs, $container);
        
        $this->assertCount(2, $filtered);
        $this->assertFalse(isset($filtered[$email->getName()]));

    }
    
    /** @test */
    public function a_closure_can_be_passed_as_a_value_instead_of_an_array_to_the_filter_action()
    {
        $filter = new Filter();

        $name = new TextInput('name', 'Name');
        
        $email = new TextInput('email', 'Email');
        $email->setRecipe(Filter::class, function($input, $params, $data){
            unset($data[$input->getname()]);
            return $data;
        });
        
        $description = new TextInput('description', 'Description');
        
        $inputs = [$name, $email, $description];
        
        $container = new DataContainer();
        $container->data = [
            'name' => "Victor Sánchez",
            'email' => 'email@email.com',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        ];

        $filtered = $filter->execute($inputs, $container);
        
        $this->assertCount(2, $filtered);
        $this->assertFalse(isset($filtered[$email->getName()]));
    }

    /** @test */
    public function the_filter_action_can_ignore_empty_values()
    {
        $filter = new Filter();

        $name = new TextInput('name', 'Name');
        
        $email = new TextInput('email', 'Email');
        $email->setRecipe(Filter::class, [
            'ignoreIfEmpty' => true
        ]);
        
        $description = new TextInput('description', 'Description');
        
        $inputs = [$name, $email, $description];
        
        $container = new DataContainer();
        $container->data = [
            'name' => "Victor Sánchez",
            'email' => '',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        ];

        $filtered = $filter->execute($inputs, $container);
        
        $this->assertCount(3, $filtered);
        $this->assertTrue(isset($filtered[$email->getName()]));
    }
}
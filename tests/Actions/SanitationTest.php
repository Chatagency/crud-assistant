<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Actions\Sanitation;

class SanitationTest extends TestCase
{
    /** @test */
    public function the_sanitation_action_is_used_to_sanitize_the_request()
    {
        $name = new TextInput('name', 'Name');
        $name->setAction(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
        
        $email = new TextInput('email', 'Email');
        $email->setAction(Sanitation::class, FILTER_SANITIZE_EMAIL);
        
        $inputs = [$name, $email];
        
        $container = new DataContainer();
        $container->requestArray = [
            'name' => "Victor O'Reilly",
            'email' => 'not_""an_email',
            'title' => 'Supervisor'
        ];
        
        $sanitation = new Sanitation();
        $rules = $sanitation->execute($inputs, $container);
        
        $this->assertNotEquals($container->requestArray['name'], $rules['name']);
        $this->assertNotEquals($container->requestArray['email'], $rules['email']);
        $this->assertEquals($container->requestArray['name'], html_entity_decode($rules['name'], ENT_QUOTES));
    }
    
    /** @test */
    public function the_raw_values_can_be_accessed_with_the_sufix_underscore_raw()
    {
        $name = new TextInput('name', 'Name');
        $name->setAction(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);

        $inputs = [$name];
        
        $container = new DataContainer();
        $container->requestArray = [
            'name' => "Victor O'Reilly",
            'title' => 'Supervisor'
        ];
        
        $sanitation = new Sanitation();
        $rules = $sanitation->execute($inputs, $container);
        
        $this->assertNotEquals($container->requestArray['name'], $rules['name']);
        $this->assertEquals($container->requestArray['name'], $rules['name_raw']);
    }
    
    /** @test */
    public function an_array_can_be_passed_as_a_value_to_the_action_with_multiple_rules()
    {
        $name = new TextInput('name', 'Name');
        $name->setAction(Sanitation::class, [
            'rules' => [
                FILTER_SANITIZE_SPECIAL_CHARS,
                FILTER_SANITIZE_MAGIC_QUOTES
            ]
        ]);
        
        $inputs = [$name];
        
        $container = new DataContainer();
        $container->requestArray = [
            'name' => "Victor O'Reill\y",
            'title' => 'Supervisor'
        ];
        
        $sanitation = new Sanitation();
        $rules = $sanitation->execute($inputs, $container);
        
        $this->assertNotEquals($container->requestArray['name'], $rules['name']);
        
    }
    
    /** @test */
    public function if_one_of_the_values_of_the_request_is_an_array_the_filter_is_applied_to_all_values()
    {
        $name = new TextInput('name', 'Name');
        $name->setAction(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
        
        $inputs = [$name];
        
        $container = new DataContainer();
        $container->requestArray = [
            'name' => [
                "Victor O'Reilly",
                "Another G'uy"
            ],
            'title' => 'Supervisor'
        ];
        
        $sanitation = new Sanitation();
        $rules = $sanitation->execute($inputs, $container);
        
        $this->assertNotEquals($container->requestArray['name'][0], $rules['name'][0]);
        $this->assertEquals($container->requestArray['name'][0], $rules['name_raw'][0]);
    }
    
    
}
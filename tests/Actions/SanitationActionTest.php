<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\Actions\SanitationAction;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Recipes\SanitationActionRecipe;
use PHPUnit\Framework\TestCase;

class SanitationActionTest extends TestCase
{
    /** @test */
    public function the_sanitation_action_is_used_to_sanitize_the_request()
    {
        $name = new TextInput('name', 'Name');
        $nameRecipe = new SanitationActionRecipe();
        $nameRecipe->type = FILTER_SANITIZE_SPECIAL_CHARS;
        $name->setRecipe($nameRecipe);

        $email = new TextInput('email', 'Email');
        $emailRecipe = new SanitationActionRecipe();
        $emailRecipe->type = FILTER_SANITIZE_EMAIL;
        $email->setRecipe($emailRecipe);

        $inputs = [$name, $email];

        $container = new DataContainer();
        $container->requestArray = [
            'name' => "Victor O'Reilly",
            'email' => 'not_""an_email',
            'title' => 'Supervisor',
        ];

        $sanitation = new SanitationAction($container);
        
        $output = new DataContainer();
        foreach($inputs as $input) {
            $output = $sanitation->execute($input,  $output);
        }
        
        $requestArray = $output->requestArray;

        $this->assertNotEquals($container->requestArray['name'], $requestArray['name']);
        $this->assertNotEquals($container->requestArray['email'], $requestArray['email']);
        $this->assertEquals($container->requestArray['name'], html_entity_decode($requestArray['name'], ENT_QUOTES));
    }

    /** @test */
    public function the_raw_values_can_be_accessed_with_the_sufix_underscore_raw()
    {
        $name = new TextInput('name', 'Name');
        $name->setRecipe(new SanitationActionRecipe([
            'type' => FILTER_SANITIZE_SPECIAL_CHARS
        ]));

        $inputs = [$name];

        $container = new DataContainer();
        $container->requestArray = [
            'name' => "Victor O'Reilly",
            'title' => 'Supervisor',
        ];

        $sanitation = new SanitationAction($container);
        
        $output = new DataContainer();
        foreach($inputs as $input) {
            $output = $sanitation->execute($input, $output);
        }

        $requestArray = $output->requestArray;

        $this->assertNotEquals($container->requestArray['name'], $requestArray['name']);
        $this->assertEquals($container->requestArray['name'], $requestArray['name_raw']);
    }

    /** @test */
    public function an_array_can_be_passed_as_a_value_to_the_action_with_multiple_rules()
    {
        $name = new TextInput('name', 'Name');
        $name->setRecipe(new SanitationActionRecipe([
            'type' => [
                ['id' => FILTER_SANITIZE_SPECIAL_CHARS]
            ],
        ]));

        $inputs = [$name];

        $container = new DataContainer();
        $container->requestArray = [
            'name' => "Victor O'Reill\y",
            'title' => 'Supervisor',
        ];

        $sanitation = new SanitationAction($container);
        
        $output = new DataContainer();
        foreach($inputs as $input) {
            $output = $sanitation->execute($input, $output);
        }

        $requestArray = $output->requestArray;

        $this->assertNotEquals($container->requestArray['name'], $requestArray['name']);
    }

    /** @test */
    public function if_one_of_the_values_of_the_request_is_an_array_the_filter_is_applied_to_all_values()
    {
        $name = new TextInput('name', 'Name');
        $name->setRecipe(new SanitationActionRecipe([
            'type' => FILTER_SANITIZE_SPECIAL_CHARS
        ]));

        $inputs = [$name];

        $container = new DataContainer();
        $container->requestArray = [
            'name' => [
                "Victor O'Reilly",
                "Another G'uy",
            ],
            'title' => 'Supervisor',
        ];

        $sanitation = new SanitationAction($container);
        
        $output = new DataContainer();
        foreach($inputs as $input) {
            $output = $sanitation->execute($input, $output);
        }

        $requestArray = $output->requestArray;

        $this->assertNotEquals($container->requestArray['name'][0], $requestArray['name'][0]);
        $this->assertEquals($container->requestArray['name'][0], $requestArray['name_raw'][0]);
    }
    
}

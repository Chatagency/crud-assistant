<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\Inputs\OptionInput;
use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\Actions\SanitationAction;
use Chatagency\CrudAssistant\Recipes\FilterRecipe;
use Chatagency\CrudAssistant\Recipes\SanitationRecipe;

class ReadmeTest extends TestCase
{
    /** 
     * @test 
     * @doesNotPerformAssertions 
     */
    public function  docs_inputs_one_test()
    {
        $email = new TextInput($inputName = 'email', $inputLabel = 'Your Email');
        $email->setType('email');
        $email->setAttribute('required', 'required');

        $hobby = new SelectInput($inputName = 'hobbies', $inputLabel = 'Your Hobbies');

        $hobbies = new InputCollection();
        $hobbies->setInputs([
            new OptionInput('Read'),
            new OptionInput('Watch movies'),
        ]);
        
        $hobby->setSubElements($hobbies);
    }

    /** 
     * @test 
     * @doesNotPerformAssertions 
     */
    public function  docs_collection_one_test()
    {
        $name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
        $name->setRecipe(new \Chatagency\CrudAssistant\Recipes\SanitationRecipe([
            'type' => FILTER_SANITIZE_SPECIAL_CHARS
        ]));
    }

    /** 
     * @test 
     * @doesNotPerformAssertions 
     */
    public function  docs_collection_two_test()
    {
        $name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
        $email = new TextInput($inputName = 'email', $inputLabel = 'Your Email');
        $email->setType('email');

        $collection = new InputCollection();
        $collection->setInputs([$name, $email]);

        $requestArray = [
            'email' => 'john@doe.com'
        ];
        
        $actionResult = $collection->execute(
            \Chatagency\CrudAssistant\Actions\SanitationAction::make()
                ->setRequestArray($requestArray)
        );
    }

    /** 
     * @test 
     * @doesNotPerformAssertions 
     */
    public function docs_collection_three_test()
    {
        $name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
        $email = new TextInput($inputName = 'email', $inputLabel = 'Your Email');
        $email->setType('email');

        $collection = new InputCollection('sub_information');
        $collection->setInputs([
            new TextInput('age', 'Your Age'),
            new TextInput('zip_code', 'Your Zip Code'),
        ]);

        $inputs = [$name, $email, $collection];

        $collection = new InputCollection();
        $collection->setInputs($inputs);
    }

    /** 
     * @test 
     * @doesNotPerformAssertions 
     */
    public function  docs_action_one_test()
    {
        // Input
        $name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
        $name->setRecipe(new SanitationRecipe([
            'type' => FILTER_SANITIZE_SPECIAL_CHARS
        ]));
        $name->setRecipe(new FilterRecipe([
            'filter' => true
        ]) );

        $collection = new InputCollection();
        $collection->setInputs([$name]);

        // sanitizes values
        $sanitized = $collection->execute(
            SanitationAction::make()->setRequestArray([
                'name' => 'John Dow'
            ])
        );
        // returns filtered values
        $rules = $collection->execute(
            FilterAction::make()->setData([
                'name' => 'John Dow'
            ])
        );
    }

    /** 
     * @test 
     * @doesNotPerformAssertions 
     */
    public function  docs_assistant_one_test()
    {
        $manager = new CrudAssistant([
            new TextInput('name')
        ]);
        
        /**
         * Or
         */
        $manager = CrudAssistant::make([
            new TextInput('name')
        ]);
    }

    /** 
     * @test 
     * @doesNotPerformAssertions 
     */
    public function  docs_assistant_two_test()
    {
        $name = new TextInput('name');
        $name->setRecipe(new FilterRecipe([
            'filter' => true
        ]));
        
        $manager = CrudAssistant::make([$name]);
        
        $action = new FilterAction();
        $action->setData([
            'name' => 'John Doe'
        ]);

        $rules = $manager->execute($action);
    
    }

}
<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\DataContainer;
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

        $data = new DataContainer([
            'requestArray' => [
                'email' => 'john@doe.com'
            ]
        ]);
        
        $actionResult = $collection->execute(new \Chatagency\CrudAssistant\Actions\SanitationAction($data));
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
        $sanitized = $collection->execute(new SanitationAction(
            new DataContainer([
                'requestArray' => [
                    'name' => 'John Dow'
                ]
            ])
        ));
        // returns filtered values
        $rules = $collection->execute(new FilterAction(
            new DataContainer([
                'data' => []
            ])
        ));
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
        
        $rules = $manager->execute(new FilterAction(
            new DataContainer([
                'data' => [
                    'name' => 'John Doe'
                ]
            ])
        ));
    
    }

}
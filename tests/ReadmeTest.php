<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\Inputs\OptionInput;
use Chatagency\CrudAssistant\Actions\Filter;
use Chatagency\CrudAssistant\Actions\Sanitation;


class ReadmeTest extends TestCase
{
    /** 
     * @test 
     * @doesNotPerformAssertions 
     */
    public function  docs_inputs_one_test()
    {
        $email = new TextInput($inputName = 'email', $inputLabel = 'Your Email', $inputVersion = 1);
        $email->setType('email');
        $email->setAttribute('required', 'required');

        $hobby = new SelectInput($inputName = 'hobbies', $inputLabel = 'Your Hobbies', $inputVersion = 1);

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
        $name->setRecipe(\Chatagency\CrudAssistant\Actions\Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /** 
     * @test 
     * @doesNotPerformAssertions 
     */
    public function  docs_collection_two_test()
    {
        $name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
        $email = new TextInput($inputName = 'email', $inputLabel = 'Your Email', $inputVersion = 1);
        $email->setType('email');

        $collection = new InputCollection();
        $collection->setInputs([$name, $email]);

        $data = new DataContainer([
            'requestArray' => []
          ]);
        
        $actionResult = $collection->execute(new \Chatagency\CrudAssistant\Actions\Sanitation($data));
    }

    /** 
     * @test 
     * @doesNotPerformAssertions 
     */
    public function docs_collection_three_test()
    {
        $name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
        $email = new TextInput($inputName = 'email', $inputLabel = 'Your Email', $inputVersion = 1);
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
        $name->setRecipe(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
        $name->setRecipe(Filter::class, [
            'filter' => true
        ]);

        $collection = new InputCollection();
        $collection->setInputs([$name]);

        // sanitizes values
        $sanitized = $collection->execute(new Sanitation(
            new DataContainer([
                'requestArray' => []
            ])
        ));
        // returns filtered values
        $rules = $collection->execute(new Filter(
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
        $name->setRecipe(Filter::class, [
            'filter' => true
        ]);
        
        $manager = CrudAssistant::make([$name]);
        
        $rules = $manager->execute(new Filter(
            new DataContainer([
                'data' => [
                    'name' => 'John Doe'
                ]
            ])
        ));
    
    }

}
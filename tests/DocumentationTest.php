<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\Inputs\OptionInput;
use Chatagency\CrudAssistant\Actions\LaravelValidationRules;
use Chatagency\CrudAssistant\Actions\Sanitation;
use Chatagency\CrudAssistant\Actions\Filter;


class DocumentationTest extends TestCase
{
    /** @test */
    public function  docs_inputs_one_test()
    {
        $email = new TextInput($inputName = 'email', $inputLabel = 'Your Email', $inputVersion = 1);
        $email->setType('email');
        $email->setAttribute('required', 'required');

        $hobby = new SelectInput($inputName = 'hobbies', $inputLabel = 'Your Hobbies', $inputVersion = 1);
        $hobby->setSubElements([
            new OptionInput('Read'),
            new OptionInput('Watch movies'),
        ]);

        $this->assertTrue(true);
    }

    /** @test */
    public function  docs_collection_one_test()
    {
        $name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
        $name->setRecipe(\Chatagency\CrudAssistant\Actions\Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);

        $this->assertTrue(true);
    }

    /** @test */
    public function  docs_collection_two_test()
    {
        $name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
        $email = new TextInput($inputName = 'email', $inputLabel = 'Your Email', $inputVersion = 1);
        $email->setType('email');

        $collection = new InputCollection([$name, $email], new ActionFactory());

        $data = new DataContainer([ 'requestArray' => []]);
        $actionResult = $collection->execute(\Chatagency\CrudAssistant\Actions\Sanitation::class,$data);

        $this->assertTrue(true);
    }

    /** @test */
    public function  docs_action_one_test()
    {
        // Input
        $name = new TextInput($inputName = 'name', $inputLabel = 'Your Name');
        $name->setRecipe(Sanitation::class, FILTER_SANITIZE_SPECIAL_CHARS);
        $name->setRecipe(LaravelValidationRules::class, [
            'required',
            'max:250'
        ]);
        
        $collection = new InputCollection([$name], new ActionFactory());
        
        // sanitizes values
        $sanitized = $collection->execute(Sanitation::class, new DataContainer([
            'requestArray' => []
        ]));
        // returns Laravel validation rules
        $rules = $collection->execute(LaravelValidationRules::class, new DataContainer());

        $this->assertTrue(true);
    }

    /** @test */
    public function  docs_assistant_one_test()
    {
        $name = new TextInput('name');
        $name->setRecipe(LaravelValidationRules::class, [
            'required',
            'max:250'
        ]);
        
        $manager = CrudAssistant::make([$name], new ActionFactory());
        
        $rules = $manager->execute(LaravelValidationRules::class);

        $this->assertTrue(true);
    }

    /** @test */
    public function  docs_assistant_two_test()
    {
        $name = new TextInput('name');
        $name->setRecipe(LaravelValidationRules::class, [
            'required',
            'max:250'
        ]);
        
        $manager = CrudAssistant::make([$name], new ActionFactory());
        
        /**
         * This
         */
        $rules = $manager->execute(LaravelValidationRules::class);
        
        /**
         * Is equal to this
         */
        $rules = $manager->LaravelValidationRules();

        $this->assertTrue(true);
    }

    /** @test */
    public function  docs_assistant_three_test()
    {

        $name = new TextInput('name');
        $name->setRecipe(Filter::class, [
          'filter' => true
        ]);
        
        $manager = CrudAssistant::make([$name], new ActionFactory());

        /**
         * This
         */
        $rules = $manager->execute(Filter::class, new DataContainer([
           'data' => []
        ]));
        
        /**
         * Is equal to this
         */
        $rules = $manager->Filter(new DataContainer([
           'data' => []
        ]));
        
        /**
         * And this
         */
        $rules = $manager->Filter([
           'data' => []
        ]);

        $this->assertTrue(true);
    }

}
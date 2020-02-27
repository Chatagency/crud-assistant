<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\Actions\LaravelValidationRules;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use PHPUnit\Framework\TestCase;

class LaravelValidationRulesTest extends TestCase
{
    /** @test */
    public function a_validation_rules_action_can_be_executed_using_an_array_of_inputs()
    {
        $name = new TextInput('name', 'Name');
        $name->setRecipe(LaravelValidationRules::class, [
            'required',
            'max:250',
        ]);

        $email = new TextInput('email', 'Email');
        $email->setRecipe(LaravelValidationRules::class, [
            'required',
            'email',
        ]);

        $validation = new LaravelValidationRules();
        $result = $validation->execute([$name, $email]);

        $this->assertCount(2, $result);
    }

    /** @test */
    public function a_closure_can_be_passed_as_a_value_instead_of_an_array_to_the_validation_rules()
    {
        $name = new SelectInput('hobbies', 'Your Hobby');
        $name->setSubElements(['run', 'play pokemon go', 'drink wine']);
        $name->setRecipe(LaravelValidationRules::class, function ($input) {
            $hobbies = $input->getSubElements();

            return [
                'required',
                Rule::in($hobbies),
            ];
        });

        $validation = new LaravelValidationRules();
        $result = $validation->execute([$name]);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(In::class, $result['hobbies'][1]);
    }
    
    /** @test */
    public function an_input_can_be_ignored_by_the_validation_rules_action()
    {
        $name = new TextInput('name', 'Name');
        $name->setRecipe(LaravelValidationRules::class, [
            'required',
            'max:250',
        ]);

        $email = new TextInput('email', 'Email');
        $email->setRecipe(LaravelValidationRules::class, [
            'ignore' => true,
        ]);

        $validation = new LaravelValidationRules();
        $result = $validation->execute([$name, $email]);

        $this->assertCount(1, $result);
    }
}

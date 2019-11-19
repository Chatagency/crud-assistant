<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Actions\LaravelValidation;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

class LaravelValidationTest extends TestCase
{
    
    /** @test */
    public function a_valition_action_can_receive_multiple_inputs()
    {
        $name = new TextInput('name', 'Name');
        $name->setAction(LaravelValidation::class, [
            'required',
            'max:250'
        ]);
        
        $email = new TextInput('email', 'Email');
        $email->setAction(LaravelValidation::class, [
            'required',
            'email'
        ]);
        
        $validation = new LaravelValidation();
        $result = $validation->execute([$name, $email]);
        
        $this->assertCount(2, $result);
        
        
    }
    
    /** @test */
    public function a_closure_can_be_passed_as_a_value_instead_of_an_array()
    {
        $name = new SelectInput('hobbies', 'Your Hobby');
        $name->setSubElements(['run', 'play pokemon go', 'drink wine']);
        $name->setAction(LaravelValidation::class, function($input) {
            $hobbies = $input->getSubElements();
            return [
                'required',
                Rule::in($hobbies),
            ];
        });
        
        $validation = new LaravelValidation();
        $result = $validation->execute([$name]);
        
        $this->assertCount(1, $result);
        $this->assertInstanceOf(In::class, $result['hobbies'][1]);
        
    }
    
}
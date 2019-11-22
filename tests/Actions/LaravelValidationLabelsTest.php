<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\Actions\LaravelValidationLabels;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\DataContainer;

class LaravelValidationLabelsTest extends TestCase
{
    /** @test */
    public function a_validation_labels_action_can_be_executed_using_an_array_of_inputs()
    {
        $name = new TextInput('name', 'Name');
        $name->setAction(LaravelValidationLabels::class, 'Your Name');
        
        $email = new TextInput('email', 'Email');
        $email->setAction(LaravelValidationLabels::class, 'Your Email');
        
        $validation = new LaravelValidationLabels();
        $result = $validation->execute([$name, $email]);
        
        $this->assertCount(2, $result);
    }
    
    /** @test */
    public function a_closure_can_be_passed_as_a_value_instead_of_an_array_to_the_validation_labels_action()
    {
        $name = new TextInput('name', 'Name');
        $name->setAction(LaravelValidationLabels::class, function ($labels, $input){
            $labels[$input->getName()] = "Your ". $input->getLabel();
            return $labels;
        });
        
        $validation = new LaravelValidationLabels();
        $result = $validation->execute([$name]);
        
        $this->assertCount(1, $result);
    }
}
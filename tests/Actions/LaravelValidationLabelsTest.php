<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\Actions\LaravelValidationLabels;
use Chatagency\CrudAssistant\Inputs\TextInput;
use PHPUnit\Framework\TestCase;

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
        $name->setAction(LaravelValidationLabels::class, function ($labels, $input) {
            $labels[$input->getName()] = 'Your '.$input->getLabel();

            return $labels;
        });

        $validation = new LaravelValidationLabels();
        $result = $validation->execute([$name]);

        $this->assertCount(1, $result);
    }

    /** @test */
    public function when_an_input_has_no_action_the_input_label_is_used()
    {
        $name = new TextInput('name', 'Name');

        $validation = new LaravelValidationLabels();
        $result = $validation->execute([$name]);
        $this->assertCount(1, $result);
        $this->assertEquals('Name', $result['name']);
    }
}

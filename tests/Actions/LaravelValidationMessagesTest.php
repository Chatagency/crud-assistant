<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\Actions\LaravelValidationMessages;
use Chatagency\CrudAssistant\Inputs\TextInput;
use PHPUnit\Framework\TestCase;

class LaravelValidationMessagesTest extends TestCase
{
    /** @test */
    public function a_validation_messages_action_can_be_executed_using_an_array_of_inputs()
    {
        $name = new TextInput('name', 'Name');
        $name->setAction(LaravelValidationMessages::class, [
            'name.required' => 'The name is required',
            'name.max' => 'The name cannot be longer than 1000 characters',
        ]);

        $email = new TextInput('email', 'Email');
        $email->setAction(LaravelValidationMessages::class, [
            'email.required' => 'The email is required',
        ]);

        $validation = new LaravelValidationMessages();
        $result = $validation->execute([$name, $email]);

        $this->assertCount(3, $result);
    }

    /** @test */
    public function a_closure_can_be_passed_as_a_value_instead_of_an_array_to_the_validation_messages()
    {
        $name = new TextInput('name', 'Name');
        $name->setAction(LaravelValidationMessages::class, function ($messages, $input) {
            $messages['name.required'] = 'The '.$input->getLabel().' is required';

            return $messages;
        });

        $validation = new LaravelValidationMessages();
        $result = $validation->execute([$name]);

        $this->assertCount(1, $result);
    }
}

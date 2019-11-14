<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\DataContainer;
use InvalidArgumentException;

class InputCollectionTest extends TestCase
{
    
    public function getCollection(array $inputs = [])
    {
        /**
         * Laravel config() is not available
         * inside the package
         * @var array
         */
        $config = require __DIR__.'/../config/config.php';
        
        return new InputCollection($inputs, new ActionFactory($config['actions']));
    }
    
    /** @test */
    public function a_collection_can_have_multiple_inputs()
    {
        $form = $this->getCollection();
        
        $form->add(new TextInput('name', 'Name'));
        $this->assertEquals($form->count(), 1);
        
        $form->add(new TextInput('email', 'Email'));
        $this->assertEquals($form->count(), 2);
    }
    
    /** @test */
    public function an_action_can_be_executed_from_the_collection()
    {
        $name = new TextInput('name', 'Name');
        $name->setAction(new DataContainer('validation', [
            'required',
            'max:250'
        ]));
        
        $email = new TextInput('email', 'Email');
        $email->setAction(new DataContainer('validation', [
            'required',
            'email'
        ]));
        
        $form = $this->getCollection([$name, $email]);
        $validation = $form->execute('validation');
        
        $this->assertNotNull($validation);
    }
    
    /** @test */
    public function an_exeption_is_thrown_if_the_action_has_not_been_registed_or_does_not_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        
        $validationValue = [
            'required',
            'email'
        ];
        
        $input = new TextInput('email', 'Email', 1);
        $input->setAction(new DataContainer('validation', $validationValue));
        
        $form = $this->getCollection([$input]);
        $form->execute('unknow');
    }
    
    /** @test */
    public function a_collection_can_contain_inputs_with_or_without_actions()
    {
        $name = new TextInput('name', 'Name');
        
        $email = new TextInput('email', 'Email');
        $email->setAction(new DataContainer('validation', [
            'required',
            'email'
        ]));
        
        $form = $this->getCollection([$name, $email]);
        $validation = $form->execute('validation');
        
        $this->assertNotNull($validation);
    }
    
}

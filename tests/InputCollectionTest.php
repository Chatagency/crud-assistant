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
    
    protected $config;
    
    public function setUp() {
        parent::setUp();
        
        /**
         * Laravel config() is not available
         * inside the package
         * @var array
         */
        $this->config = require __DIR__.'/../config/config.php';
    }
    
    public function getCollection(array $inputs = [])
    {
        return new InputCollection($inputs, new ActionFactory($this->config['actions']));
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
        $validationValue = [
            'required',
            'email'
        ];
        
        $input = new TextInput('email', 'Email', 1);
        $input->setAction(new DataContainer('validation', $validationValue));
        $form = $this->getCollection([$input]);
        $validation = $form->execute('validation');
        
        $this->assertNotNull($validation);
        
    }
    
    /** @test */
    public function an_exeption_is_thrown_if_the_action_has_not_been_registed_or_does_not_exist()
    {
        $validationValue = [
            'required',
            'email'
        ];
        
        $input = new TextInput('email', 'Email', 1);
        $input->setAction(new DataContainer('validation', $validationValue));
        $form = $this->getCollection([$input]);
        
        $this->expectException(InvalidArgumentException::class);
        $validation = $form->execute('unknow');
    }
    
}

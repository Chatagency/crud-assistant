<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Processes\Validation;
use Chatagency\CrudAssistant\ActionFactory;

class InputCollectionTest extends TestCase
{
    
    public function getCollection(array $inputs = [])
    {
        $config = require_once __DIR__.'/../config/config.php';
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
    
    // /** @test */
    public function a_process()
    {
        
    }
    
}

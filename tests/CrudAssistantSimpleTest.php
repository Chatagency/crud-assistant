<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\Crud;
use Chatagency\CrudAssistant\CrudAssistant;

class CrudAssistantSimpleTest extends TestCase
{
    /** @test */
    public function crud_assistant_can_be_instanciated()
    {
        $crud = new Crud;
        $assistant = new CrudAssistant();
    }
}

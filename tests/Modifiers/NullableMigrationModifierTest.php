<?php

namespace Chatagency\CrudAssistant\Tests\Modifiers;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Modifiers\NullableMigrationModifier;
use Illuminate\Database\Schema\Blueprint;

class NullableMigrationModifierTest extends TestCase
{
    /** @test */
    public function the_nullable_migration_adds_the_nullable_modifier_to_the_migration()
    {
        $blueprint = new Blueprint('contacts', function (Blueprint $table){
            $table = (new NullableMigrationModifier())->modify($table->string('name'), null);
        });
        
        $columns = $blueprint->getColumns();
        $attributes = $columns[0]->getAttributes();
        
        $this->assertTrue($attributes['nullable']);
        
    }
    
}

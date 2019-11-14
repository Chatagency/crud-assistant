<?php

return [
    "actions" => [
        "database" => Chatagency\CrudAssistant\Actions\Database::class,
        "migration" => Chatagency\CrudAssistant\Actions\Migration::class,
        "sanitaion" => Chatagency\CrudAssistant\Actions\Sanitation::class,
        "validation" => Chatagency\CrudAssistant\Actions\Validation::class,
    ]
];
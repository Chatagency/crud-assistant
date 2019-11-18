<?php

return [
    "actions" => [
        "sanitation" => Chatagency\CrudAssistant\Actions\Sanitation::class,
        "laravel-database" => Chatagency\CrudAssistant\Actions\LaravelDatabase::class,
        "laravel-migration" => Chatagency\CrudAssistant\Actions\LaravelMigration::class,
        "laravel-model" => Chatagency\CrudAssistant\Actions\LaravelModel::class,
        "laravel-validation" => Chatagency\CrudAssistant\Actions\LaravelValidation::class,
    ]
];
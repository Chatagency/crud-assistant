<?php

$rules = [
    '@Symfony' => true,
    '@Symfony:risky' => true,
    '@PHP71Migration' => true,
    'array_syntax' => ['syntax' => 'short'],
    'dir_constant' => true,
    'heredoc_to_nowdoc' => true,
    'linebreak_after_opening_tag' => true,
    'modernize_types_casting' => true,
    'no_multiline_whitespace_before_semicolons' => true,
    'no_unreachable_default_argument_value' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'ordered_class_elements' => true,
    'ordered_imports' => true,
    'phpdoc_add_missing_param_annotation' => ['only_untyped' => false],
    'phpdoc_order' => true,
    'declare_strict_types' => true,
    'doctrine_annotation_braces' => true,
    'doctrine_annotation_indentation' => true,
    'doctrine_annotation_spaces' => true,
    'psr4' => true,
    'no_php4_constructor' => true,
    'no_short_echo_tag' => true,
    'semicolon_after_instruction' => true,
    'align_multiline_comment' => true,
    'doctrine_annotation_array_assignment' => true,
    'general_phpdoc_annotation_remove' => ['annotations' => ["author", "package"]],
    'list_syntax' => ["syntax" => "short"],
    'phpdoc_types_order' => ['null_adjustment'=> 'always_last'],
    'single_line_comment_style' => true,
    'is_null' => ["use_yoda_style" => false],
    'yoda_style' => [
        'equal' => false,
        'identical' => false,
        'less_and_greater' => false,
    ],
];

$exclude = [
    'config',
    'tests',
    'build',
    'vendor',
    'helpers',
];

$finder = PhpCsFixer\Finder::create()
    ->exclude($exclude)
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setCacheFile(__DIR__.'/.php_cs.cache')
    ->setFinder($finder);


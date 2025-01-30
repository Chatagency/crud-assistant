<?php

declare(strict_types=1);

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Fixer\Internal\ConfigurableFixerTemplateFixer;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

return (new Config())
    ->setParallelConfig(ParallelConfigFactory::detect()) // @TODO 4.0 no need to call this manually
    ->setRiskyAllowed(true)
    ->registerCustomFixers([
        new ConfigurableFixerTemplateFixer(),
    ])
    // ->setRules([
    //     '@Symfony' => true,
    //     '@Symfony:risky' => true,
    //     '@PHP71Migration' => true,
    //     'array_syntax' => ['syntax' => 'short'],
    //     'dir_constant' => true,
    //     'heredoc_to_nowdoc' => true,
    //     'linebreak_after_opening_tag' => true,
    //     'modernize_types_casting' => true,
    //     'no_multiline_whitespace_before_semicolons' => true,
    //     'no_unreachable_default_argument_value' => true,
    //     'no_useless_else' => true,
    //     'no_useless_return' => true,
    //     'ordered_class_elements' => true,
    //     'ordered_imports' => true,
    //     'phpdoc_add_missing_param_annotation' => ['only_untyped' => false],
    //     'phpdoc_order' => true,
    //     'declare_strict_types' => true,
    //     'doctrine_annotation_braces' => true,
    //     'doctrine_annotation_indentation' => true,
    //     'doctrine_annotation_spaces' => true,
    //     'psr4' => true,
    //     'no_php4_constructor' => true,
    //     'no_short_echo_tag' => true,
    //     'semicolon_after_instruction' => true,
    //     'align_multiline_comment' => true,
    //     'doctrine_annotation_array_assignment' => true,
    //     'general_phpdoc_annotation_remove' => ['annotations' => ["author", "package"]],
    //     'list_syntax' => ["syntax" => "short"],
    //     'phpdoc_types_order' => ['null_adjustment'=> 'always_last'],
    //     'single_line_comment_style' => true,
    //     'is_null' => ["use_yoda_style" => false],
    //     'yoda_style' => [
    //         'equal' => false,
    //         'identical' => false,
    //         'less_and_greater' => false,
    //     ],
    // ])
    ->setRules([
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,
        '@PHPUnit100Migration:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'PhpCsFixerInternal/configurable_fixer_template' => true, // internal rules, shall not be used outside of main repo
        'general_phpdoc_annotation_remove' => ['annotations' => ['expectedDeprecation']], // one should use PHPUnit built-in method instead
        'header_comment' => ['header' => <<<'EOF'
            This file is part of PHP CS Fixer.

            (c) Fabien Potencier <fabien@symfony.com>
                Dariusz Rumiński <dariusz.ruminski@gmail.com>

            This source file is subject to the MIT license that is bundled
            with this source code in the file LICENSE.
            EOF],
        'modernize_strpos' => true, // needs PHP 8+ or polyfill
        'no_useless_concat_operator' => false, // TODO switch back on when the `src/Console/Application.php` no longer needs the concat
        'numeric_literal_separator' => true,
        'declare_strict_types' => true,
    ])
    ->setFinder(
        (new Finder())
            ->ignoreDotFiles(false)
            ->ignoreVCSIgnored(true)
            ->exclude(['dev-tools/phpstan', 'tests/Fixtures'])
            ->in(__DIR__)
            ->append([__DIR__.'/php-cs-fixer'])
    )
;

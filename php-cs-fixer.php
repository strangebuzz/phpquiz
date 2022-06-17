<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('code')
    ->exclude('snapshots')
    ->exclude('tmp')
;

return (new PhpCsFixer\Config())->setRules([
    '@Symfony' => true,
    'array_syntax' => ['syntax' => 'short'],
    'declare_strict_types' => true,
    'no_superfluous_phpdoc_tags' => true,
    'php_unit_fqcn_annotation' => false,
    'yoda_style' => false,
    'native_function_invocation' => [         // https://cs.symfony.com/doc/rules/function_notation/native_function_invocation.html
        'include' => ['@compiler_optimized'],
        'scope' => 'namespaced',
        'strict' => true,
    ], ])
->setFinder($finder);

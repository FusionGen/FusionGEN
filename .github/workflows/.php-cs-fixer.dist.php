<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('system')
    ->notPath('')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
        'strict_param' => false,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;
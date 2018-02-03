<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Backend Module',
    'description' => 'A convenience extension for quickly creating TYPO3 backend modules',
    'category' => 'be',
    'author' => 'Christian Fries',
    'author_email' => 'hello@christian-fries.ch',
    'state' => 'stable',
    'version' => '0.7.6',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.7.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'classmap' => ['Classes']
    ],
];

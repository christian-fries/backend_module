<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Backend Module',
    'description' => 'A convenience extension for quickly creating TYPO3 backend modules',
    'category' => 'be',
    'author' => 'Christian Fries',
    'author_email' => 'hello@christian-fries.ch',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'classmap' => ['Classes']
    ],
];

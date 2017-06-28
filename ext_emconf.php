<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Backend Module',
    'description' => 'A base extension for TYPO3 backend modules',
    'category' => 'be',
    'author' => 'Christian Fries',
    'author_email' => 'hallo@christian-fries.ch',
    'state' => 'alpha',
    'clearCacheOnLoad' => 0,
    'version' => '0.7.0',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.7.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'classmap' => array('Classes')
    ],
];
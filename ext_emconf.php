<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Content Blocks GUI',
    'description' => 'GUI for TYPO3 CMS Content Blocks - Content Types API.',
    'category' => 'be',
    'author' => 'TYPO3 Content Types Team',
    'author_email' => 'typo3cms@typo3.org',
    'author_company' => '',
    'state' => 'alpha',
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.99.99',
            'content_blocks' => '*',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

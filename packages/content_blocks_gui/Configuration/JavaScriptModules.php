<?php

return [
    'dependencies' => ['core', 'backend'],
    'imports' => [
        '@contentblocks/content-blocks-gui/' => 'EXT:content_blocks_gui/Resources/Public/dist/',
        // TODO: remove if vue app can send the specified ajax requests
        '@contentblocks/content-blocks-gui-testfiles/' => 'EXT:content_blocks_gui/Resources/Public/JavaScript/',
    ],
];

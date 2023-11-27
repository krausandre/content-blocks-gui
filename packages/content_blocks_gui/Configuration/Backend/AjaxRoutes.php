<?php

/**
 * Definitions for routes provided by EXT:content_blocks_gui
 */
return [
    'create_cb' => [
        'path' => '/contentblocks/gui/cb/create',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::createCb',
    ],
];

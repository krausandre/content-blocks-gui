<?php

/**
 * Definitions for routes provided by EXT:content_blocks_gui
 */
return [
    'list_cb' => [
        'path' => '/contentblocks/gui/cb/list',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::listCbAction',
    ],
    'create_cb' => [
        'path' => '/contentblocks/gui/cb/create',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::createCbAction',
    ],
    'get_cb' => [
        'path' => '/contentblocks/gui/cb/get',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::getCbAction',
    ],
    'delete_cb' => [
        'path' => '/contentblocks/gui/cb/delete',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::deleteCbAction',
    ],
    'translate_cb' => [
        'path' => '/contentblocks/gui/cb/translate',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::translateCbAction',
    ],
    'save_cb' => [
        'path' => '/contentblocks/gui/cb/save',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::saveCbAction',
    ],
    'download_cb' => [
        'path' => '/contentblocks/gui/cb/download',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::downloadCbAction',
    ],
    'copy_cb' => [
        'path' => '/contentblocks/gui/cb/copy',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::copyCbAction',
    ],
    'list_ext' => [
        'path' => '/contentblocks/gui/ext/list',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::listExtAction',
    ],
    'list_icons' => [
        'path' => '/contentblocks/gui/icons/list',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::listIconsAction',
    ],
];

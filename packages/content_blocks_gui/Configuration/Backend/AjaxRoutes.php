<?php

/**
 * Definitions for routes provided by EXT:content_blocks_gui
 */
return [
    'content_blocks_gui_list_cb' => [
        'path' => '/contentblocks/gui/cb/list',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::listCbAction',
    ],
    'content_blocks_gui_get_cb' => [
        'path' => '/contentblocks/gui/cb/get',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::getCbAction',
    ],
    'content_blocks_gui_delete_cb' => [
        'path' => '/contentblocks/gui/cb/delete',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::deleteCbAction',
    ],
    'content_blocks_gui_translate_cb' => [
        'path' => '/contentblocks/gui/cb/translate',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::translateCbAction',
    ],
    'content_blocks_gui_save_cb' => [
        'path' => '/contentblocks/gui/cb/save',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::saveCbAction',
    ],
    'content_blocks_gui_download_cb' => [
        'path' => '/contentblocks/gui/cb/download',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::downloadCbAction',
    ],
    'content_blocks_gui_copy_cb' => [
        'path' => '/contentblocks/gui/cb/copy',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::copyCbAction',
    ],
    'content_blocks_gui_list_ext' => [
        'path' => '/contentblocks/gui/ext/list',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::listExtAction',
    ],
    'content_blocks_gui_list_icons' => [
        'path' => '/contentblocks/gui/icons/list',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::listIconsAction',
    ],
    'content_blocks_gui_list_groups' => [
        'path' => '/contentblocks/gui/groups/list',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::listGroupsAction',
    ],
    'content_blocks_gui_list_basics' => [
        'path' => '/contentblocks/gui/basics/list',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::listBasicsAction',
    ],
];

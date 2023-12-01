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
    'content_blocks_gui_save_content_type' => [
        'path' => '/contentblocks/gui/contenttype/save',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::saveContentTypeAction',
    ],
    'content_blocks_gui_download_cb' => [
        'path' => '/contentblocks/gui/cb/download',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::downloadCbAction',
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
    'content_blocks_gui_get_basics' => [
        'path' => '/contentblocks/gui/basics/get',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::getBasicAction',
    ],
    'content_blocks_gui_get_translation' => [
        'path' => '/contentblocks/gui/translation/get',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::getTranslationAction',
    ],
    'content_blocks_gui_save_translation' => [
        'path' => '/contentblocks/gui/translation/save',
        'target' => \ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController::class . '::saveTranslationAction',
    ],
];

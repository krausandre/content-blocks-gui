<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiController;
use ContentBlocks\ContentBlocksGui\Controller\Backend\ContentBlocksGuiAjaxController;

$_LLL_mod = 'LLL:EXT:content_blocks_gui/Resources/Private/Language/locallang_mod.xlf:';
return [
    'web_ContentBlocksGui' => [
        'parent' => 'tools',
        'position' => ['after' => 'web_info'],
        'access' => 'admin',
        'workspaces' => 'live',
        'icon' => 'EXT:content_blocks_gui/Resources/Public/Icons/Extension.svg',
        'path' => '/module/web/ContentBlocksGui',
        'labels' => $_LLL_mod . 'content-blocks-gui',
        'extensionName' => 'content_blocks_gui',
        'controllerActions' => [
            ContentBlocksGuiController::class => [
                'list',
            ],
            ContentBlocksGuiAjaxController::class => [
                'listCb',
                'createCb',
                'getCb',
                'deleteCb',
                'getCb',
                'translateCb',
                'saveCb',
                'downloadCb',
                'copyCb',
                'listExt',
            ]
        ],
    ],
];

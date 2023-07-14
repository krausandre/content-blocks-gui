<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

call_user_func(static function () {
    ExtensionManagementUtility::addTypoScriptSetup('
        module.tx_contentblocksgui {
            view {
                templateRootPaths {
                    20 = EXT:content_blocks_gui/Resources/Private/Backend/Templates/ContentBlocks/
                }
                partialRootPaths {
                    20 = EXT:content_blocks_gui/Resources/Private/Backend/Partials/
                }
                layoutRootPaths {
                    20 = EXT:content_blocks_gui/Resources/Private/Backend/Layouts/
                }
            }
        }');
});

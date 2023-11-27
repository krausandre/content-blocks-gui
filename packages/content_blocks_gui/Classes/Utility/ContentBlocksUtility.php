<?php

declare(strict_types=1);

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

namespace ContentBlocks\ContentBlocksGui\Utility;

use TYPO3\CMS\ContentBlocks\Definition\TableDefinition;
use TYPO3\CMS\ContentBlocks\Loader\ContentBlockLoader;

class ContentBlocksUtility
{
    public function __construct(
        protected ContentBlockLoader $contentBlocksLoader
    ) {
    }

    public function getAvailableContentBlocks(): array
    {
        $resultList = [
            'ContentElements' => [],
            'PageTypes' => [],
            'RecordTypes' => [],
        ];
        $contentBlocksList = $this->contentBlocksLoader->load(false);

        /** @var TableDefinition */
        foreach ($contentBlocksList as $contentBlock) {
            switch ($contentBlock->getTable()) {
                case 'tt_content':
                    $resultList['ContentElements'][] = $contentBlock;
                    break;

                case 'pages':
                    $resultList['PageTypes'][] = $contentBlock;
                    break;

                default:
                    $resultList['RecordTypes'][] = $contentBlock;
                    break;
            }
        }
        return $resultList;
    }
}

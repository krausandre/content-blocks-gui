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
use TYPO3\CMS\ContentBlocks\Registry\ContentBlockRegistry;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContentBlocksUtility
{
    public function __construct(
        protected ContentBlockLoader $contentBlocksLoader,
        protected ContentBlockRegistry $contentBlockRegistry,
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
                    $resultList['ContentElements'] = $this->dataForContentBlockList($contentBlock, $resultList['ContentElements']);
                    break;

                case 'pages':
                    $resultList['PageTypes'] = $this->dataForContentBlockList($contentBlock, $resultList['PageTypes']);
                    break;

                default:
                    $resultList['RecordTypes'] = $this->dataForContentBlockList($contentBlock, $resultList['RecordTypes']);
                    break;
            }
        }
        return $resultList;
    }

    protected function dataForContentBlockList(TableDefinition $tableDefinition, array $list): array
    {
        $languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)
                ->createFromUserPreferences($GLOBALS['BE_USER']);
        foreach ($tableDefinition->getContentTypeDefinitionCollection() as $typeDefinition) {
            $loadedContentBlock = $this->contentBlockRegistry->getContentBlock($typeDefinition->getName());
            $list[] = [
                'identifier' => $loadedContentBlock->getName(),
                'name' => $languageService->sL(
                    $typeDefinition->getLanguagePathTitle()
                ),
                'extension' => $loadedContentBlock->getHostExtension(),
            ];
        }
        return $list;
    }
}

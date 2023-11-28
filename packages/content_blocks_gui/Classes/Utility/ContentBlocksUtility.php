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
use TYPO3\CMS\ContentBlocks\Definition\TableDefinitionCollection;
use TYPO3\CMS\ContentBlocks\Registry\ContentBlockRegistry;
use TYPO3\CMS\Core\Localization\LanguageService;

class ContentBlocksUtility
{
    public function __construct(
        protected readonly TableDefinitionCollection $tableDefinitionCollection,
        protected readonly ContentBlockRegistry $contentBlockRegistry,
    ) {
    }

    public function getAvailableContentBlocks(): array
    {
        $resultList = [];
        foreach ($this->tableDefinitionCollection as $tableDefinition) {
            $contentType = $tableDefinition->getContentType();
            $resultList[$contentType->name] ??= [];
            $resultList[$contentType->name] += $this->getLoadedContentBlocksForTable($tableDefinition);
        }
        return $resultList;
    }

    protected function getLoadedContentBlocksForTable(TableDefinition $tableDefinition): array
    {
        $list = [];
        $languageService = $this->getLanguageService();
        foreach ($tableDefinition->getContentTypeDefinitionCollection() as $typeDefinition) {
            $loadedContentBlock = $this->contentBlockRegistry->getContentBlock($typeDefinition->getName());
            $name = $languageService->sL($typeDefinition->getLanguagePathTitle());
            $list[$loadedContentBlock->getName()] = [
                'identifier' => $loadedContentBlock->getName(),
                'name' => $name,
                'extension' => $loadedContentBlock->getHostExtension(),
            ];
        }
        return $list;
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}

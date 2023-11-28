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
use TYPO3\CMS\ContentBlocks\Registry\LanguageFileRegistry;
use TYPO3\CMS\ContentBlocks\Utility\ContentBlockPathUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Package\Exception;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extensionmanager\Utility\InstallUtility;

class ContentBlocksUtility
{
    public function __construct(
        protected readonly TableDefinitionCollection $tableDefinitionCollection,
        protected readonly ContentBlockRegistry $contentBlockRegistry,
        protected readonly ContentBlockPathUtility $contentBlockPathUtility,
        protected readonly LanguageFileRegistry $languageFileRegistry,
    ) {
    }

    /**
     * @throws Exception
     */
    public function deleteContentBlockByIdentifier(string $identifier): void
    {
        $contentBlockPath = $this->contentBlockRegistry->getContentBlockPath($identifier);
        $absoluteContentBlockPath = ExtensionManagementUtility::resolvePackagePath($contentBlockPath);
        //delete files and folders recursively from path
        $this->deleteDirectoryRecurisvely($absoluteContentBlockPath);
    }

    private function deleteDirectoryRecurisvely($contentBlockPath): void
    {
        if (is_dir($contentBlockPath)) {
            $currentDirectory = opendir($contentBlockPath);

            while (($file = readdir($currentDirectory)) !== false) {
                if ($file != "." && $file != "..") {
                    $currentFile = $contentBlockPath . DIRECTORY_SEPARATOR . $file;

                    if (is_dir($currentFile)) {
                        $this->deleteDirectoryRecurisvely($currentFile);
                    } else {
                        unlink($currentFile);
                    }
                }
            }
            closedir($currentDirectory);
            rmdir($contentBlockPath);
        } elseif (is_file($contentBlockPath)) {
            unlink($contentBlockPath);
        } else {
            // TODO: throw exception or give hint that some parts could not be deleted?!
        }
    }

    public function createZipFileFromContentBlockPath(string $identifier): string
    {
        $contentBlock = $this->contentBlockRegistry->getContentBlock($identifier);
        $contentBlockPath = $contentBlock->getExtPath();
        $contentBlockPackage = '/' . $contentBlock->getPackage();
        $absoluteContentBlockPath = ExtensionManagementUtility::resolvePackagePath($contentBlockPath);
        $temporaryPath = Environment::getVarPath() . '/transient/';
        if (!@is_dir($temporaryPath)) {
            GeneralUtility::mkdir($temporaryPath);
        }
        $fileName = $temporaryPath . $contentBlock->getPackage() . '_' . date('YmdHi', $GLOBALS['EXEC_TIME']) . '.zip';

        $zip = new \ZipArchive();
        $zip->open($fileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $files = GeneralUtility::getAllFilesAndFoldersInPath(
            [], // No files pre-added
            $absoluteContentBlockPath . '/', // Start from here
            '', // Do not filter files by extension
            true, // Include subdirectories
            PHP_INT_MAX
        );
        // Make paths relative to content block directory.
        $files = GeneralUtility::removePrefixPathFromList($files, $absoluteContentBlockPath);
        $files = is_array($files) ? $files : [];

        foreach ($files as $file) {
            $fullPath = $absoluteContentBlockPath . $file;
            // Distinguish between files and directories, as creation of the archive
            // fails on Windows when trying to add a directory with "addFile".
            if (is_dir($fullPath)) {
                $zip->addEmptyDir($contentBlockPackage . $file);
            } else {
                $zip->addFile($fullPath, $contentBlockPackage . $file);
            }
        }
        $zip->close();

        return $fileName;
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
            $label = $languageService->sL($typeDefinition->getLanguagePathTitle());
            $list[$loadedContentBlock->getName()] = [
                'name' => $loadedContentBlock->getName(),
                'label' => $label,
                'extension' => $loadedContentBlock->getHostExtension(),
            ];
        }
        return $list;
    }

    public function getContentBlockByName(string $name): array
    {
        $loadedContentBlock = $this->contentBlockRegistry->getContentBlock($name);
        $contentBlockAsArray = $loadedContentBlock->toArray();
        $contentBlockAsArray['languageFile'] = $this->languageFileRegistry->getLanguageFile($name);
        return $contentBlockAsArray;
    }

    public function hasContentBlock(string $name): bool
    {
        return $this->contentBlockRegistry->hasContentBlock($name);
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}

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

use ContentBlocks\ContentBlocksGui\Answer\AnswerInterface;
use ContentBlocks\ContentBlocksGui\Answer\DataAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorContentBlockNotFoundAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorMissingContentBlockNameAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorNoBasicsAvailableAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorNoContentBlocksAvailableAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorUnknownContentBlockPathAnswer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Yaml\Yaml;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\ContentBlocks\Basics\BasicsLoader;
use TYPO3\CMS\ContentBlocks\Basics\BasicsRegistry;
use TYPO3\CMS\ContentBlocks\Basics\LoadedBasic;
use TYPO3\CMS\ContentBlocks\Builder\ContentBlockConfiguration;
use TYPO3\CMS\ContentBlocks\Builder\ContentBlockSkeletonBuilder;
use TYPO3\CMS\ContentBlocks\Definition\ContentType\ContentType;
use TYPO3\CMS\ContentBlocks\Definition\TableDefinition;
use TYPO3\CMS\ContentBlocks\Definition\TableDefinitionCollection;
use TYPO3\CMS\ContentBlocks\Registry\ContentBlockRegistry;
use TYPO3\CMS\ContentBlocks\Registry\LanguageFileRegistry;
use TYPO3\CMS\ContentBlocks\Service\CreateContentType;
use TYPO3\CMS\ContentBlocks\Service\PackageResolver;
use TYPO3\CMS\ContentBlocks\Utility\ContentBlockPathUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Package\Exception;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContentBlocksUtility
{
    public function __construct(
        protected readonly LoggerInterface $logger,
        protected readonly TableDefinitionCollection $tableDefinitionCollection,
        protected readonly ContentBlockRegistry $contentBlockRegistry,
        protected readonly ContentBlockPathUtility $contentBlockPathUtility,
        protected readonly LanguageFileRegistry $languageFileRegistry,
        protected readonly BasicsRegistry $basicsRegistry,
        protected readonly BasicsLoader $basicsLoader,
        protected readonly PackageResolver $packageResolver,
        protected readonly CreateContentType $createContentType,
        protected readonly ContentBlockSkeletonBuilder $contentBlockBuilder,
    ) {
    }

    public function saveContentBlock(object|array|null $getParsedBody): DataAnswer
    {
        $vendor = $getParsedBody['vendor'];
        $name = $getParsedBody['name'];
        $extension = $getParsedBody['extension'];
        $fields = json_decode($getParsedBody['fields'], true);
        $basics = $getParsedBody['basics'] ?? [];
        $group = $getParsedBody['group'] ?? 'common';
        $prefixFields = $getParsedBody['prefixFields'] ?? true;
        $prefixType = $getParsedBody['prefixType'] ?? 'full';
        $table = $getParsedBody['table'] ?? 'tt_content';
        $typeField = $getParsedBody['typeField'] ?? 'CType';

        if($this->hasContentBlock($vendor . '/' . $name)) {
            $yamlConfiguration = $this->createContentType->createContentBlockContentElementConfiguration(
                $vendor,
                $name,
                $fields,
                $basics,
                $group,
                $prefixFields,
                $prefixType,
                $table,
                $typeField
            );
            $basePath = $this->createContentType->getBasePath($this->packageResolver->getAvailablePackages(), $extension, ContentType::CONTENT_ELEMENT);
            file_put_contents(
                $basePath . '/' . $name . '/' . ContentBlockPathUtility::getContentBlockDefinitionFileName(),
                Yaml::dump($yamlConfiguration, 10, 2),
            );
        } else {
            $this->createContentBlockConfiguration(
                $vendor,
                $name,
                $fields,
                $basics,
                $group,
                $prefixFields,
                $prefixType,
                $table,
                $typeField,
                $extension,
            );
        }
        return new DataAnswer(
            'list',
            [ 'name' => $vendor . '/' . $name ]
        );
    }

    protected function createContentBlockConfiguration(
        $vendor,
        $name,
        $fields,
        $basics,
        $group,
        $prefixFields,
        $prefixType,
        $table,
        $typeField,
        $extension,
    ): void {
        $availablePackages = $this->packageResolver->getAvailablePackages();
        $yamlConfiguration = $this->createContentType->createContentBlockContentElementConfiguration(
            $vendor,
            $name,
            $fields,
            $basics,
            $group,
            $prefixFields,
            $prefixType,
            $table,
            $typeField
        );

        $contentBlockConfiguration = new ContentBlockConfiguration(
            yamlConfig: $yamlConfiguration,
            basePath: $this->createContentType->getBasePath($availablePackages, $extension, ContentType::CONTENT_ELEMENT),
            contentType: ContentType::CONTENT_ELEMENT
        );

        $this->contentBlockBuilder->create($contentBlockConfiguration);
    }

    public function deleteContentBlock(null|array|object $parsedBody): AnswerInterface
    {
        if (array_key_exists('name', $parsedBody)) {
            try {
                $absoluteContentBlockPath = ExtensionManagementUtility::resolvePackagePath(
                    $this->contentBlockRegistry->getContentBlockPath($parsedBody['name'])
                );
                return new DataAnswer(
                    'list',
                    $this->deleteDirectoryRecursively($absoluteContentBlockPath)
                );
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());
                return new ErrorUnknownContentBlockPathAnswer($parsedBody['name']);
            }
        } else {
            return new ErrorMissingContentBlockNameAnswer();
        }
    }

    /**
     * @throws Exception
     */
    private function deleteDirectoryRecursively(string $path): array
    {
        $notDeletedFilePaths = [];
        if (is_dir($path)) {
            $currentDirectory = opendir($path);

            while (($file = readdir($currentDirectory)) !== false) {
                if ($file != "." && $file != "..") {
                    $currentFile = $path . DIRECTORY_SEPARATOR . $file;

                    if (is_dir($currentFile)) {
                        $this->deleteDirectoryRecursively($currentFile);
                    } else {
                        unlink($currentFile);
                    }
                }
            }
            closedir($currentDirectory);
            rmdir($path);
        } elseif (is_file($path)) {
            unlink($path);
        } else {
            // add hint that some parts could not be deleted
            $notDeletedFilePaths[] = $path;
        }
        return $notDeletedFilePaths;
    }

    public function createZipFileFromContentBlockPath(string $name): string
    {
        $contentBlock = $this->contentBlockRegistry->getContentBlock($name);
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

    public function getAvailableContentBlocks(): AnswerInterface
    {
        $resultList = [];
        foreach ($this->tableDefinitionCollection as $tableDefinition) {
            $contentType = $tableDefinition->getContentType();
            $resultList[$contentType->name] ??= [];
            $resultList[$contentType->name] += $this->getLoadedContentBlocksForTable($tableDefinition);
        }
        if (empty($resultList)) {
            return new ErrorNoContentBlocksAvailableAnswer();
        }
        return new DataAnswer(
            'list',
            $resultList
        );
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

    public function getContentBlockByName(null|array|object $parsedBody): AnswerInterface
    {
        if (array_key_exists('name', $parsedBody)) {
            if ($this->hasContentBlock($parsedBody['name'])) {
                $loadedContentBlock = $this->contentBlockRegistry->getContentBlock($parsedBody['name']);
                $contentBlockAsArray = $loadedContentBlock->toArray();
                $contentBlockAsArray['languageFile'] = $this->languageFileRegistry->getLanguageFile($parsedBody['name']);
                return new DataAnswer(
                    'ContentBlock',
                    $contentBlockAsArray
                );
            }
            return new ErrorContentBlockNotFoundAnswer($parsedBody['name']);
        }
        return new ErrorMissingContentBlockNameAnswer();
    }

    public function getIconsList(): AnswerInterface
    {
        $resultList = [];
        foreach ($this->tableDefinitionCollection as $tableDefinition) {
            foreach ($tableDefinition->getContentTypeDefinitionCollection() ?? [] as $typeDefinition) {
                $resultList[$typeDefinition->getName()] = $typeDefinition->getTypeIconIdentifier();
            }
        }
        return new DataAnswer(
            'iconList',
            $resultList
        );
    }

    public function getGroupsList(): AnswerInterface
    {
        $result = [];
        $languageService = $this->getLanguageService();
        $pageTsConfig = BackendUtility::getPagesTSconfig(0);
        $contentWizardGroups = $pageTsConfig['mod.']['wizards.']['newContentElement.']['wizardItems.'] ?? [];
        foreach ($contentWizardGroups as $key => $value) {
            $result[str_replace('.', '', $key)] = $languageService->sL($value['header']);
        }

        return new DataAnswer(
            'groupList',
            $result
        );
    }

    public function getBasicList(): AnswerInterface
    {
        $resultList = [];
        $this->basicsLoader->load();
        /** @var LoadedBasic */
        foreach ($this->basicsRegistry->getAllBasics() as $basic) {
            $resultList[$basic->getIdentifier()] = $basic->toArray();
        }
        if (empty($resultList)) {
            return new ErrorNoBasicsAvailableAnswer();
        }
        return new DataAnswer(
            'basicList',
            $resultList
        );
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

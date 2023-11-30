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
use ContentBlocks\ContentBlocksGui\Answer\ErrorBasicNotFoundAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorContentBlockNotFoundAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorDownloadContentTypeAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorMissingBasicIndentifierAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorMissingContentBlockNameAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorNoBasicsAvailableAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorNoContentBlocksAvailableAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorSaveContentTypeAnswer;
use ContentBlocks\ContentBlocksGui\Answer\ErrorUnknownContentBlockPathAnswer;
use ContentBlocks\ContentBlocksGui\Factory\UsageFactory;
use ContentBlocks\ContentBlocksGui\Service\ContentTypeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\ContentBlocks\Basics\BasicsLoader;
use TYPO3\CMS\ContentBlocks\Basics\BasicsRegistry;
use TYPO3\CMS\ContentBlocks\Builder\ContentBlockSkeletonBuilder;
use TYPO3\CMS\ContentBlocks\Definition\Factory\UniqueIdentifierCreator;
use TYPO3\CMS\ContentBlocks\Definition\TableDefinitionCollection;
use TYPO3\CMS\ContentBlocks\Loader\ContentBlockLoader;
use TYPO3\CMS\ContentBlocks\Loader\LoadedContentBlock;
use TYPO3\CMS\ContentBlocks\Registry\ContentBlockRegistry;
use TYPO3\CMS\ContentBlocks\Registry\LanguageFileRegistry;
use TYPO3\CMS\ContentBlocks\Service\CreateContentType;
use TYPO3\CMS\ContentBlocks\Service\PackageResolver;
use TYPO3\CMS\ContentBlocks\Utility\ContentBlockPathUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Http\ResponseFactory;
use TYPO3\CMS\Core\Http\StreamFactory;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Package\Exception;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

class ContentBlocksUtility
{
    public function __construct(
        protected readonly LoggerInterface $logger,
        protected readonly ResponseFactory $responseFactory,
        protected readonly StreamFactory $streamFactory,
        protected readonly TableDefinitionCollection $tableDefinitionCollection,
        protected readonly ContentBlockRegistry $contentBlockRegistry,
        protected readonly ContentBlockPathUtility $contentBlockPathUtility,
        protected readonly LanguageFileRegistry $languageFileRegistry,
        protected readonly BasicsRegistry $basicsRegistry,
        protected readonly BasicsLoader $basicsLoader,
        protected readonly PackageResolver $packageResolver,
        protected readonly CreateContentType $createContentType,
        protected readonly ContentBlockSkeletonBuilder $contentBlockBuilder,
        protected readonly ContentTypeService $contentTypeService,
        protected readonly ContentBlockLoader $contentBlockLoader,
        protected readonly UsageFactory $usageFactory,
        protected readonly ExtensionUtility $extensionUtility
    ) {
    }

    public function saveContentType(object|array|null $getParsedBody): AnswerInterface
    {
        try {
            $data = $this->contentTypeService->getContentTypeData($getParsedBody);
            return match ($getParsedBody['contentType']) {
                'content-element' => $this->contentTypeService->handleContentElement($data),
                'page-type' => $this->contentTypeService->handlePageType($data),
                'record-type' => $this->contentTypeService->handleRecordType($data),
                'basic' => $this->contentTypeService->handleBasic($data)
            };
        } catch(\RuntimeException $e) {
            $this->logger->error($e->getMessage());
            return new ErrorSaveContentTypeAnswer($e->getMessage());
        }
    }

    public function downloadContentBlock(object|array|null $getParsedBody): ResponseInterface
    {
        try {
            if(!isset($getParsedBody['name'])) {
                $errorAnswer = new ErrorContentBlockNotFoundAnswer($getParsedBody['name']);
                return $errorAnswer->getResponse();
            }
            $fileName = $this->createZipFileFromContentBlockPath($getParsedBody['name']);
            $response = $this->responseFactory
                ->createResponse()
                ->withAddedHeader('Content-Type', 'application/zip')
                ->withAddedHeader('Content-Length', (string)(filesize($fileName) ?: ''))
                ->withAddedHeader('Content-Disposition', 'attachment; filename="' . PathUtility::basename($fileName) . '"')
                ->withBody($this->streamFactory->createStreamFromFile($fileName));

            unlink($fileName);

            return $response;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $errorAnswer = new ErrorDownloadContentTypeAnswer($e->getMessage());
            return $errorAnswer->getResponse();
        }
    }

    public function deleteContentBlock(null|array|object $parsedBody): AnswerInterface
    {
        if (array_key_exists('name', $parsedBody)) {
            try {
                $absoluteContentBlockPath = ExtensionManagementUtility::resolvePackagePath(
                    $this->contentBlockRegistry->getContentBlockExtPath($parsedBody['name'])
                );
                $notDeletedFilePaths = $this->deleteDirectoryRecursively($absoluteContentBlockPath);
                $this->contentBlockLoader->loadUncached();
                return new DataAnswer(
                    'list',
                    $notDeletedFilePaths
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

    /**
     * @throws Exception
     */
    public function createZipFileFromContentBlockPath(string $name): string
    {
        $contentBlock = $this->contentBlockRegistry->getContentBlock($name);
        $absoluteContentBlockPath = ExtensionManagementUtility::resolvePackagePath($contentBlock->getExtPath());
        $temporaryPath = Environment::getVarPath() . '/transient/';
        if (!@is_dir($temporaryPath)) {
            GeneralUtility::mkdir($temporaryPath);
        }
        $fileName = $temporaryPath . $contentBlock->getPackage() . '_' . date('YmdHi', time()) . '.zip';

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
                $zip->addEmptyDir('/' . $contentBlock->getPackage() . $file);
            } else {
                $zip->addFile($fullPath, '/' . $contentBlock->getPackage() . $file);
            }
        }
        $zip->close();

        return $fileName;
    }

    public function getAvailableContentBlocks(): AnswerInterface
    {
        $resultList = [];
        foreach ($this->contentBlockRegistry->getAll() as $contentBlock) {
            $contentType = $contentBlock->getContentType();
            $resultList[$contentType->name][$contentBlock->getName()] = $this->loadedContentBlockToArray($contentBlock);
        }
        $resultList['BASICS'] = $this->getLoadedBasicForList();
        if (empty($resultList)) {
            return new ErrorNoContentBlocksAvailableAnswer();
        }
        return new DataAnswer(
            'list',
            $resultList
        );
    }

    protected function loadedContentBlockToArray(LoadedContentBlock $contentBlock): array
    {
        $typeName = $contentBlock->getYaml()['typeName'] ?? UniqueIdentifierCreator::createContentTypeIdentifier($contentBlock);
        $table = $contentBlock->getContentType()->getTable() ?? $contentBlock->getYaml()['table'];
        // @todo We might not want to add this feature. This could lead to performance problems.
        $usages = $this->usageFactory->countUsages($contentBlock->getContentType(), $typeName, $table);

        $tableDefinition = $this->tableDefinitionCollection->getTable($table);
        if ($tableDefinition->hasTypeField()) {
            $typeDefinition = $tableDefinition->getContentTypeDefinitionCollection()->getType($typeName);
        } else {
            $typeDefinition = $tableDefinition->getDefaultTypeDefinition();
        }
        $label = $this->getLanguageService()->sL($typeDefinition->getLanguagePathTitle());

        $result = [
            'name' => $contentBlock->getName(),
            'label' => $label,
            'extension' => $contentBlock->getHostExtension(),
            'editable' => $this->extensionUtility->isEditable($contentBlock->getHostExtension()),
            'deletable' => $this->extensionUtility->isEditable($contentBlock->getHostExtension()),
            'usages' => $usages,
        ];

        return $result;
    }

    protected function getLoadedBasicForList(): array
    {
        $list = [];
        $this->basicsLoader->load();
        foreach ($this->basicsRegistry->getAllBasics() as $basic) {
            $list[$basic->getIdentifier()] = [
                'name' => $basic->getIdentifier(),
                'label' => $basic->getIdentifier(),
                'extension' => $basic->getHostExtension(),
                'editable' => true,
                'deletable' => true,
            ];
        }
        return $list;
    }

    public function getContentBlockByName(null|array|object $parsedBody): AnswerInterface
    {
        if (array_key_exists('name', $parsedBody)) {
            if ($this->contentBlockRegistry->hasContentBlock($parsedBody['name'])) {
                $loadedContentBlock = $this->contentBlockRegistry->getContentBlock($parsedBody['name']);
                $contentBlockAsArray = $loadedContentBlock->toArray();
                return new DataAnswer(
                    'contentBlock',
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

    public function getBasicByName(null|array|object $parsedBody): AnswerInterface
    {
        $this->basicsLoader->load();
        if (array_key_exists('identifier', $parsedBody)) {
            if ($this->basicsRegistry->hasBasic($parsedBody['identifier'])) {
                return new DataAnswer(
                    'basicList',
                    $this->basicsRegistry->getBasic($parsedBody['identifier'])->toArray()
                );
            }
            return new ErrorBasicNotFoundAnswer($parsedBody['identifier']);
        }
        return new ErrorMissingBasicIndentifierAnswer();
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
